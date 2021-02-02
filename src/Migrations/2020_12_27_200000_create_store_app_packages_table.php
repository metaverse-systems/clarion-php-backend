<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreAppPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_app_packages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('app_id');
            $table->string('type');
            $table->string('organization');
            $table->string('name');
            $table->string('version');
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('migrated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_app_packages');
    }
}
