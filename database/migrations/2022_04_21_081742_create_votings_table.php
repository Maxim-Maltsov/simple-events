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
        Schema::create('votings', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('time_phase_1')->unsigned();
            $table->integer('time_phase_2')->unsigned();
            $table->integer('start_timestamp_phase_1')->unsigned();
            $table->integer('start_timestamp_phase_2')->unsigned();
            $table->boolean('finished')->default(false);
            $table->bigInteger('winned_event_id')->nullable();
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
        Schema::dropIfExists('votings');
        
    }
};
