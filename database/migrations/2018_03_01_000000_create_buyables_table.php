<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyablesTable extends Migration
{
    public function up()
    {
        Schema::create('buyables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('spec');
            $table->unsignedInteger('amount');
            $table->decimal('price');
            $table->morphs('buyable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropTable('buyables');
    }
}
