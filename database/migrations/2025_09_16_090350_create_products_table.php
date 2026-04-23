<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('country_of_origin')->nullable();
            $table->text('manufacture_date')->nullable();
            $table->text('net_quantity')->nullable();
            $table->text('care_instructions')->nullable();
            $table->text('disclaimer')->nullable();
            $table->text('color')->nullable();
            $table->text('collection')->nullable();
            $table->text('brand')->nullable();
            $table->string('slug')->unique();

            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            // $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->decimal('old_price', 10, 2)->nullable();
            $table->integer('discount_percent')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_new')->default(false); //  remove ->after('is_popular')
            $table->unsignedBigInteger('views')->default(0); //  remove ->after('is_new')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
