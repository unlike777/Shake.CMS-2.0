<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('text')->default('');
            $table->string('file');
            $table->string('field');
            $table->integer('parent_id', false, true)->index();
            $table->string('parent_type');
            $table->boolean('is_file');
            $table->timestamps();
        });
    
        Schema::create('files', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('file');
            $table->string('field');
            $table->integer('sort');
            $table->integer('parent_id', false, true)->index();
            $table->string('parent_type');
            $table->timestamps();
        });
    
        Schema::create('pages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->boolean('active');
            $table->string('slug')->index();
            $table->string('link');
            $table->string('title');
            $table->text('content');
            $table->string('template');
            $table->integer('page_id', false, true)->index();
            $table->boolean('is_home');
            $table->integer('position', false, true)->index();
            $table->string('file');
            $table->timestamps();
        });
    
        Schema::create('regs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('key')->index();
            $table->string('value');
            $table->timestamps();
        });
    
        Schema::create('seo_texts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('keywords');
            $table->string('description');
            $table->integer('parent_id', false, true)->index();
            $table->string('parent_type');
            $table->timestamps();
        });
    
        Schema::create('settings', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('alias')->index();
            $table->text('text');
            $table->timestamps();
        });
    
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('group', ['', 'admin'])->index();
            $table->rememberToken();
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
        Schema::dropIfExists('fields');
        Schema::dropIfExists('files');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('regs');
        Schema::dropIfExists('seo_texts');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('users');
    }
}
