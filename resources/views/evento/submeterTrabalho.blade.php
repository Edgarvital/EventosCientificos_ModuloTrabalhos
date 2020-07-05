@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                  <h2 class="card-title">{{$evento->nome}}</h2>
                  <h4 class="card-title">{{$modalidade->nome}}</h4>
                  <div class="titulo-detalhes"></div>
                  <br>
                  <h4 class="card-title">Enviar Trabalho</h4>
                  <p class="card-text">
                    <form method="POST" action="{{route('trabalho.store', $modalidade->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">
                        <input type="hidden" name="modalidadeId" value="{{$modalidade->id}}">
                        <div>
                          @error('tipoExtensao')
                            @include('componentes.mensagens')
                          @enderror
                        </div>
                        <div>
                          @error('numeroMax')
                            @include('componentes.mensagens')
                          @enderror
                        </div>
                        <?php
                          $ordemCampos = explode(",", $formSubTraba->ordemCampos);
                        ?>
                        @foreach ($ordemCampos as $indice)
                          @if ($indice == "etiquetatitulotrabalho")
                            <div class="row justify-content-center">
                              {{-- Nome Trabalho  --}}
                              <div class="col-sm-12">
                                  <label for="nomeTrabalho" class="col-form-label">{{ $formSubTraba->etiquetatitulotrabalho }}</label>
                                  <input id="nomeTrabalho" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeTrabalho" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus>

                                  @error('nomeTrabalho')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                            </div>
                          @endif
                          @if ($indice == "etiquetaautortrabalho")
                            <div class="row justify-content-center">
                              {{-- Autor  --}}
                              <div class="col-sm-12">
                                  <label for="nomeTrabalho" class="col-form-label">{{$formSubTraba->etiquetaautortrabalho}}</label>
                                  <input class="form-control" type="text" disabled value="{{Auth::user()->name}}">
                              </div>
                            </div>
                          @endif
                          @if ($indice == "etiquetacoautortrabalho")
                            <div class="row" style="margin-top:20px">
                              <div class="col-sm-12">
                                <div id="coautores">
    
                                </div>
                                <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">{{$formSubTraba->etiquetacoautortrabalho}}</a>
                              </div>
                            </div>
                          @endif
                          @if ($indice == "etiquetaresumotrabalho")
                            @if ($modalidade->caracteres == true)
                              <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="resumo" class="col-form-label">{{$formSubTraba->etiquetaresumotrabalho}}</label>
                                    <textarea id="resumo" class="char-count form-control @error('resumo') is-invalid @enderror" data-ls-module="charCounter" minlength="{{$modalidade->mincaracteres}}" maxlength="{{$modalidade->maxcaracteres}}" name="resumo" value="{{ old('resumo') }}"  autocomplete="resumo" autofocusrows="5"></textarea>
                                    <p class="text-muted"><small><span name="resumo">0</span></small> - Min Caracteres: {{$modalidade->mincaracteres}} - Max Caracteres: {{$modalidade->maxcaracteres}}</p>
                                    @error('resumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                              </div>                              
                            @elseif ($modalidade->palavras == true)
                              <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="resumo" class="col-form-label">{{$formSubTraba->etiquetaresumotrabalho}}</label>
                                    <textarea id="palavra" class="form-control palavra @error('resumo') is-invalid @enderror" name="resumo" value="{{ old('resumo') }}"  autocomplete="resumo" autofocusrows="5"></textarea>
                                    <p class="text-muted"><small><span id="numpalavra">0</span></small> - Min Palavras: {{$modalidade->minpalavras}} - Max Palavras: {{$modalidade->maxpalavras}}</p>
                                    @error('resumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                              </div>
                            @endif
                          @endif
                          @if ($indice == "etiquetaareatrabalho")
                            <!-- Areas -->
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="area" class="col-form-label">{{$formSubTraba->etiquetaareatrabalho}}</label>
                                    <select class="form-control @error('area') is-invalid @enderror" id="area" name="areaId">
                                        <option value="" disabled selected hidden>-- Área --</option>
                                        {{-- @foreach($areasEnomes as $area)
                                          <option value="{{$area->id}}">{{$area->nome}}</option>
                                        @endforeach --}}
                                        {{-- Apenas um teste abaixo --}}
                                        @foreach($areasEspecificas as $area)
                                          <option value="{{$area->id}}">{{$area->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('areaId')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                          @endif
                          @if ($indice == "etiquetauploadtrabalho")
                            <div class="row justify-content-center">
                              {{-- Submeter trabalho --}}

                              @if ($modalidade->arquivo == true)
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="nomeTrabalho" class="col-form-label">{{$formSubTraba->etiquetauploadtrabalho}}</label>
    
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivo" required>
                                  </div>
                                  <small>Arquivos aceitos nos formatos 
                                    @if($modalidade->pdf == true)pdf - @endif
                                    @if($modalidade->jpg == true)jpg - @endif
                                    @if($modalidade->jpeg == true)jpeg - @endif
                                    @if($modalidade->png == true)png - @endif
                                    @if($modalidade->docx == true)docx - @endif
                                    @if($modalidade->odt == true)odt @endif.</small>
                                  @error('arquivo')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            </div>
                          @endif
                          @if ($indice == "etiquetacampoextra1")
                            @if ($formSubTraba->checkcampoextra1 == true)
                              @if ($formSubTraba->tipocampoextra1 == "textosimples")  
                                {{-- Texto Simples --}}
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                  <div class="col-sm-12">
                                        <label for="campoextra1" class="col-form-label">{{ $formSubTraba->etiquetacampoextra1}}:</label>
                                        <input id="campoextra1" type="text" class="form-control @error('campoextra1') is-invalid @enderror" name="campoextra1" value="{{ old('campoextra1') }}" required autocomplete="campoextra1" autofocus>
      
                                        @error('campoextra1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra1 == "textogrande")
                                {{-- Texto Grande --}}
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra1" class="col-form-label">{{ $formSubTraba->etiquetacampoextra1}}:</label>
                                      <textarea id="campoextra1" type="text" class="form-control @error('campoextra1') is-invalid @enderror" name="campoextra1" value="{{ old('campoextra1') }}" required autocomplete="campoextra1" autofocus></textarea>
      
                                      @error('campoextra1')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra1 == "upload")
                                {{-- Arquivo de Regras  --}}
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="campoextra1" class="col-form-label">{{ $formSubTraba->etiquetacampoextra1}}:</label>
            
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="campoextra1">
                                  </div>
                                  <small>Algum texto aqui?</small>
                                  @error('campoextra1')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            @endif
                          @endif
                          @if ($indice == "etiquetacampoextra2")
                            @if ($formSubTraba->checkcampoextra2 == true)
                              @if ($formSubTraba->tipocampoextra2 == "textosimples")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra2" class="col-form-label">{{ $formSubTraba->etiquetacampoextra2}}:</label>
                                      <input id="campoextra2" type="text" class="form-control @error('campoextra2') is-invalid @enderror" name="campoextra2" value="{{ old('campoextra2') }}" required autocomplete="campoextra2" autofocus>
          
                                      @error('campoextra2')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra2 == "textogrande")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra2" class="col-form-label">{{ $formSubTraba->etiquetacampoextra2}}:</label>
                                      <textarea id="campoextra2" type="text" class="form-control @error('campoextra2') is-invalid @enderror" name="campoextra2" value="{{ old('campoextra2') }}" required autocomplete="campoextra2" autofocus></textarea>
          
                                      @error('campoextra2')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra2 == "upload")
                                {{-- Arquivo de Regras  --}}
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="campoextra2" class="col-form-label">{{ $formSubTraba->etiquetacampoextra2}}:</label>
            
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="campoextra2">
                                  </div>
                                  <small>Algum texto aqui?</small>
                                  @error('campoextra2')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            @endif
                          @endif
                          @if ($indice == "etiquetacampoextra3")
                            @if ($formSubTraba->checkcampoextra3 == true)
                              @if ($formSubTraba->tipocampoextra3 == "textosimples")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra3" class="col-form-label">{{ $formSubTraba->etiquetacampoextra3}}:</label>
                                      <input id="campoextra3" type="text" class="form-control @error('campoextra3') is-invalid @enderror" name="campoextra3" value="{{ old('campoextra3') }}" required autocomplete="campoextra3" autofocus>
      
                                      @error('campoextra3')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra3 == "textogrande")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra3" class="col-form-label">{{ $formSubTraba->etiquetacampoextra3}}:</label>
                                      <textarea id="campoextra3" type="text" class="form-control @error('campoextra3') is-invalid @enderror" name="campoextra3" value="{{ old('campoextra3') }}" required autocomplete="campoextra3" autofocus></textarea>
      
                                      @error('campoextra3')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra3 == "upload")
                                {{-- Arquivo de Regras  --}}
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="campoextra3" class="col-form-label">{{ $formSubTraba->etiquetacampoextra3}}:</label>
            
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="campoextra3">
                                  </div>
                                  <small>Algum texto aqui?</small>
                                  @error('campoextra3')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            @endif
                          @endif
                          @if ($indice == "etiquetacampoextra4")
                            @if ($formSubTraba->checkcampoextra4 == true)
                              @if ($formSubTraba->tipocampoextra4 == "textosimples")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra4" class="col-form-label">{{ $formSubTraba->etiquetacampoextra4}}:</label>
                                      <input id="campoextra4" type="text" class="form-control @error('campoextra4') is-invalid @enderror" name="campoextra4" value="{{ old('campoextra4') }}" required autocomplete="campoextra4" autofocus>
      
                                      @error('campoextra4')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra4 == "textogrande")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra4" class="col-form-label">{{ $formSubTraba->etiquetacampoextra4}}:</label>
                                      <textarea id="campoextra4" type="text" class="form-control @error('campoextra4') is-invalid @enderror" name="campoextra4" value="{{ old('campoextra4') }}" required autocomplete="campoextra4" autofocus></textarea>
      
                                      @error('campoextra4')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra4 == "upload")
                                {{-- Arquivo de Regras  --}}
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="campoextra4" class="col-form-label">{{$formSubTraba->etiquetacampoextra4}}:</label>
            
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="campoextra4">
                                  </div>
                                  <small>Algum texto aqui?</small>
                                  @error('campoextra4')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            @endif
                          @endif
                          @if ($indice == "etiquetacampoextra5")
                            @if ($formSubTraba->checkcampoextra5 == true)
                              @if ($formSubTraba->tipocampoextra5 == "textosimples")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra5" class="col-form-label">{{ $formSubTraba->etiquetacampoextra5}}:</label>
                                      <input id="campoextra5" type="text" class="form-control @error('campoextra5') is-invalid @enderror" name="campoextra5" value="{{ old('campoextra5') }}" required autocomplete="campoextra5" autofocus>
      
                                      @error('campoextra5')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra5 == "textogrande")
                                <div class="row justify-content-center">
                                  {{-- Nome Trabalho  --}}
                                <div class="col-sm-12">
                                      <label for="campoextra5" class="col-form-label">{{ $formSubTraba->etiquetacampoextra5}}:</label>
                                      <textarea id="campoextra5" type="text" class="form-control @error('campoextra5') is-invalid @enderror" name="campoextra5" value="{{ old('campoextra5') }}" required autocomplete="campoextra5" autofocus></textarea>
      
                                      @error('campoextra5')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
                              @elseif ($formSubTraba->tipocampoextra5 == "upload")
                                {{-- Arquivo de Regras  --}}
                                <div class="col-sm-12" style="margin-top: 20px;">
                                  <label for="campoextra5" class="col-form-label">{{ $formSubTraba->etiquetacampoextra5}}:</label>
            
                                  <div class="custom-file">
                                    <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="campoextra5">
                                  </div>
                                  <small>Algum texto aqui?</small>
                                  @error('campoextra5')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </div>
                              @endif
                            @endif
                          @endif
                        @endforeach
                  </p>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <a href="{{route('evento.visualizar',['id'=>$evento->id])}}" class="btn btn-secondary" style="width:100%">Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Enviar') }}
                            </button>
                        </div>
                    </div>
                    
                    </form>
                </div>
              </div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
<script type="text/javascript">

  var modalidades = JSON.parse('<?php echo json_encode($modalidadesIDeNome) ?>');

  $(document).ready(function(){
    $('.char-count').keyup(function() {
        var maxLength = parseInt($(this).attr('maxlength')); 
        var length = $(this).val().length;
        // var newLength = maxLength-length;
        
        var name = $(this).attr('name');
        
        $('span[name="'+name+'"]').text(length);
    });
  });

  $(document).ready(function(){
    $('.palavra').keyup(function() {
        var maxLength = parseInt($(this).attr('maxlength')); 
        var texto = $(this).val().length;
        console.log(texto);
        if ($(this).val()[length - 1] == " ") {
          var cont = $(this).val().length;
          // console.log("Contador:");
          // console.log(cont);
        }

        // console.log("Texto:");
        // console.log(texto);

        var name = $(this).attr('name');
        
        $('span[name="'+name+'"]').text(length);
    });
  });

  // function getLength() {
  //       getWord = document.getElementById( 'palavra' ).value,
  //       num = document.getElementById( 'numpalavra' );
        
  //       if ( getWord == '' ){
  //         console.log("IF");
  //         num.textContent = '0';
  //       }
  //       else if ( getWord.search( /\s[a-z0-9]+$/gi ) > -1 ) num.textContent = getWord.split( ' ' ).length;
  //       else if ( getWord.search( /[^\s]$/ ) > -1 ) num.textContent = '1';
  // }

  $(function(){
    // Coautores
    $('#addCoautor').click(function(){
      linha = montarLinhaInput();
      $('#coautores').append(linha);
    });

    // Exibir modalidade de acordo com a área
    $("#area").change(function(){
      console.log($(this).val());
      addModalidade($(this).val());
    });


  });
  // Remover Coautor
  $(document).on('click','.delete',function(){
    $(this).closest('.row').remove();
          return false;
  });

  function addModalidade(areaId){
    console.log(modalidades)
    $("#modalidade").empty();
    for(let i = 0; i < modalidades.length; i++){
      if(modalidades[i].areaId == areaId){
        console.log(modalidades[i]);
        $("#modalidade").append("<option value="+modalidades[i].modalidadeId+">"+modalidades[i].modalidadeNome+"</option>")
      }
    }
  }
  function montarLinhaInput(){

    return  "<div class="+"row"+">"+
                "<div class="+"col-sm-6"+">"+
                    "<label>Nome Completo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'nomeCoautor[]'+" placeholder="+"Nome"+" required>"+
                "</div>"+
                "<div class="+"col-sm-5"+">"+
                    "<label>E-mail</label>"+
                    "<input"+" type="+'email'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'emailCoautor[]'+" placeholder="+"E-mail"+" required>"+
                "</div>"+
                "<div class="+"col-sm-1"+">"+
                    "<a href="+"#"+" class="+"delete"+">"+
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
            "</div>";
  }
</script>
@endsection
