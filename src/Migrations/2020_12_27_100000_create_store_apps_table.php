<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_apps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('organization');
            $table->string('name');
            $table->string('version');
            $table->text('description');
            $table->text('storepage');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_homepage');
            $table->timestamp('installed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_apps');
    }
}
