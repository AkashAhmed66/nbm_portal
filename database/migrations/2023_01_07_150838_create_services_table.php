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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained('service_categories');
            $table->string('title', 200)->nullable(false);
            $table->text('shortDesc')->nullable(false);
            $table->longText('description')->nullable(false);
            $table->string('icon', 50)->default('icon_easel');
            $table->string('thumb', 200)->default('no_thumb.jpg');
            $table->string('btnText', 50)->default('Read More');
            $table->string('singleThumb', 200)->default('no_single_thumb.jpg');
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
        Schema::dropIfExists('services');
    }
};
