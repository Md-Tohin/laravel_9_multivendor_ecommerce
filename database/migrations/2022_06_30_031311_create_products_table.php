<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->integer('category_id');
            $table->integer('brand_id')->nullable();
            $table->integer('vendor_id');
            $table->integer('admin_id');
            $table->string('admin_type');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->float('product_price');
            $table->float('product_discount')->nullable();
            $table->integer('product_weight')->nullable();
            $table->string('group_code')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_video')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('is_featured',['Yes','No'])->default('No');
            $table->enum('is_bestseller',['Yes','No'])->default('No');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('products');
    }
};
