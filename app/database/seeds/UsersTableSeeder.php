<?php

class UsersTableSeeder extends DatabaseSeeder {

	public function run()
	{
		$now = date('Y-m-d H:i:s');
		$users = [
			[
				'username' => 'admin',
				'name' => 'admin',
				'lastname' => 'admin',
				'birthdate' => date('Y-m-d'),
				'password' => Hash::make('admin'),
				'email' => 'admin@admin.fr',
				'created_at' => $now,
				'updated_at' => $now
			],
		];
		DB::table('users')->insert($users);
	}

}
