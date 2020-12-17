<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
class AssignUsersRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        $user = User::find(1);
        $user->assignRole('Super Admin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        $user = User::find(1);
        $user->removeRole('Super Admin');
    }
}
