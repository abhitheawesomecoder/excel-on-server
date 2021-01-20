<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('permissions')->insert([
          'name' => 'users.settings',
          'guard_name' => 'web',
          "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
          "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
      ]);
    }
}
