<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialWikiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // Table columns.
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');

            // Meta columns.
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // References.
            $table->foreign(['created_by'])->references('id')->on('users')->onDelete('set null');
            $table->foreign(['updated_by'])->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('articles', function (Blueprint $table) {
            // Table columns.
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');

            // Article contents should be stored relative to storage path. eg. /articles/{id}.
            // Article sections should be stored as {heading_as_snake_case}.html.
            // Todo: Articles could be stored in cloud storage (S3, Rackspace, etc...)
            // Todo: Articles do not currently store images. But they will be stored within the article store.
            $table->string('article_store_path')->nullable();

            // Meta columns.
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // References.
            $table->foreign(['created_by'])->references('id')->on('users')->onDelete('set null');
            $table->foreign(['updated_by'])->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('articles_categories', function (Blueprint $table) {
            // Table columns.
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('category_id');

            // Compound key.
            $table->primary(['article_id', 'category_id']);

            // References.
            $table->foreign(['article_id'])->references('id')->on('articles')->onDelete('cascade');
            $table->foreign(['category_id'])->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('links', function (Blueprint $table) {
            // Table columns.
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('url');

            // Meta columns.
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // References.
            $table->foreign(['created_by'])->references('id')->on('users')->onDelete('set null');
            $table->foreign(['updated_by'])->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('tags', function (Blueprint $table) {
            // Table columns.
            $table->increments('id');
            $table->string('taggable_type');
            $table->unsignedInteger('taggable_id');
            $table->string('tag');

            // Meta columns.
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            // References.
            $table->foreign(['created_by'])->references('id')->on('users')->onDelete('set null');
            $table->foreign(['updated_by'])->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('tags');
        Schema::dropIfExists('links');
        Schema::dropIfExists('articles_categories');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('categories');

        Schema::enableForeignKeyConstraints();
    }
}
