<?php

use App\Models\App;
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
        Schema::create('deployments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App::class);
            $table->string('hash');
            $table->string('ref');
            $table->string('message');
            $table->string('committer_name');
            $table->string('committer_username')->nullable();
            $table->string('committer_email')->nullable();
            $table->timestamp('commited_at')->nullable();
            $table->timestamp('pushed_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
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
        Schema::dropIfExists('deployments');
    }
};
