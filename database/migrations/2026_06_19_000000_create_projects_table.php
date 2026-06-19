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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained('service_categories');
            $table->string('title', 200)->nullable(false);
            $table->longText('description')->nullable(false);
            $table->string('image', 200)->default('no_thumb.jpg');
            $table->string('clientName', 200)->nullable();
            $table->string('location', 200)->nullable();
            $table->string('duration', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->tinyInteger('sln')->autoIncrement(false);
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
        Schema::dropIfExists('projects');
    }
};
