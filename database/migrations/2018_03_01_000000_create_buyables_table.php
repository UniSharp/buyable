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
            $table->string('vendor')->nullable();
            $table->morphs('buyable');
            $table->unique(['buyable_type', 'buyable_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropTable('specs');
    }
}
