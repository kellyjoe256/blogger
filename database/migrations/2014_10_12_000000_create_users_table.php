<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 50)
                ->unique()
                ->index('ix_email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 150);
            $table->boolean('super_user')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
