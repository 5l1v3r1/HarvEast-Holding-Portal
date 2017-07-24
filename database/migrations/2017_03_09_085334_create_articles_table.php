
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('body');
            $table->string('media')->nullable();
            $table->boolean('is_anchored')->default(0);
            $table->boolean('is_highlighted')->default(0);
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->string('slug')->unique();
            $table->timestamp('anchored_from')->nullable();
            $table->timestamp('anchored_to')->nullable();
            $table->timestamps();
        });

        Schema::create('article_views', function (Blueprint $table) {
            $table->integer('article_id')->index()->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->primary(['article_id','user_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_views');
        Schema::dropIfExists('articles');
    }
}
