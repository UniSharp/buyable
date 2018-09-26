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
            $table->text('meta')->nullable()->default(null);
            $table->integer('status')->default(0);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->morphs('buyable');
            $table->unique(['buyable_type', 'buyable_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyables');
    }
}
