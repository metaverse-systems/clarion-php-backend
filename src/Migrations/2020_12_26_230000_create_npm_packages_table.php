<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNPMPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npm_packages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('app_install_id')->nullable();
            $table->string('name');
            $table->string('version');
            $table->timestamp('installed_at')->nullable();
            $table->string('dep_type')->default('dependency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('npm_packages');
    }
}
