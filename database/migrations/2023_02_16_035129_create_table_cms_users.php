<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCmsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('cms_privileges_id')->nullable()->index('index_1');
            $table->string('name', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password', 255)->nullable();
        });

        Schema::create('cms_privileges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->nullable();
        });

        Schema::create('cms_notification', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('cms_users_id')->nullable()->index('index_1');
            $table->longText('content')->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('is_read')->default('0')->comment('Is notification read fill with 1, else 0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_users');
        Schema::dropIfExists('cms_privileges');
        Schema::dropIfExists('cms_notification');
    }
}
