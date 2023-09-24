<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCmsModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_module', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('path', 255)->nullable();
            $table->string('table_name', 255)->nullable();
            $table->string('controller', 255)->nullable();
            $table->string('type', 255)->nullable()->comment('route, menu');
            $table->integer('is_active')->default(0)->comment('0 = not active, 1 = is active');
            $table->integer('sorting')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_module');
    }
}
