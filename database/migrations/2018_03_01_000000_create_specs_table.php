<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecsTable extends Migration
{
    public function up()
    {
        Schema::create('specs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('price');
            $table->string('sku')->nullable();
            $table->integer('sold_qty')->nullable()->default(0);
            $table->morphs('specifiable');
            $table->unique(['specifiable_type', 'specifiable_id', 'name']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specs');
    }
}
