<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('page_id')->default(-1);
            $table->bigInteger('user_id');
            $table->string("type")->default('PageController');
            $table->string("title");
            $table->string("link");
            $table->string("label");
            $table->bigInteger('sort_order')->default(1);
            $table->string("template")->nullable();
            $table->string("layout")->nullable();
            $table->string("view")->nullable();
            $table->text("meta")->nullable();
            $table->text("seo")->nullable();
            $table->text("data")->nullable();
            $table->string("version")->enum("live,draft,removed");
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
