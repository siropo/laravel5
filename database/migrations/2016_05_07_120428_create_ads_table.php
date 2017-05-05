<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->text('body');
            $table->float('price')->unsigned();
            $table->boolean('negotiation');
            $table->boolean('publish_phone');
            $table->enum('delivery', ['buyer', 'seller', 'personally']);
            $table->enum('condition', ['new', 'used']);
            $table->longtext('location');
            $table->longtext('pictures');
            $table->string('video_link');
            $table->timestamps();
            $table->timestamp('published_at');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('ads_type')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ads');
    }
}
