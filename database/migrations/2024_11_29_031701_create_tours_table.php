<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('destination');
            $table->string('image');
            $table->string('season');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('days');
            $table->integer('nights');
            $table->integer('minimum_pax');
            $table->integer('leader')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('total_fare', 8, 2)->nullable();
            $table->decimal('additional_fare', 8, 2)->nullable();
            $table->decimal('return_fare', 8, 2)->nullable();
            $table->string('status')->default('active'); // Added the status column
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
        Schema::dropIfExists('tours');
    }
}
