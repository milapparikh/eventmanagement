<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            //$table->integer('category_id');
            //$table->integer('category_id')->unsigned();
            $table->unsignedInteger('category_id');
            $table->date('event_date');
            $table->text('location');            
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')->on('categorys')
                ->onDelete('cascade')
                ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
