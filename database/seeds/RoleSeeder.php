<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('roles')->insert([
          'name' => 'Contractor',
          'guard_name' => 'web',
          "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
          "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
      ]);
    }
}
