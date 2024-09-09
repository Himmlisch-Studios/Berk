<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->uuid('webhook_id')->index();
            $table->string('label');
            $table->string('domain');
            $table->string('directory');
            $table->string('branch');
            $table->string('repository');
            $table->tinyInteger('provider')->unsigned();
            $table->text('script')->nullable();
            $table->boolean('enable')->default(false);
            $table->boolean('enable_script')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
};
