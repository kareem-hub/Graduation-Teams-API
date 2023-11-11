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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('team_type_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('title', 50)->unique();
            $table->longText('body')->nullable();
            $table->boolean('published')->default(true);
            $table->unsignedSmallInteger('members')->default(0);
            $table->unsignedSmallInteger('avg_rating')->nullable();
            $table->unique(['user_id', 'title', 'team_type_id']);
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
        Schema::dropIfExists('teams');
    }
};
