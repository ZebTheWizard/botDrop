<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedCanvasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $url = $table->string('url')->unique();
            $table->string('image')->default('/image/blank.png');
            $table->string('name')->nullable();
            $table->boolean('isOwner')->default(TRUE);
            $table->boolean('isNew')->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
            $url->collation = 'utf8_bin';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canvases');
    }
}
