<?php

use Illuminate\Database\Seeder;

class AdministradorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user_id = DB::table('users')->where('name','Administrador')->pluck('id');

		DB::table('administradors')->insert([
		    'user_id' => $user_id[0],
		]);
	}
}
