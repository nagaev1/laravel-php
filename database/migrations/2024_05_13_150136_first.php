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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ru_name');
            $table->text('discription');
            $table->text('image');
            $table->foreignId('status_id');
            $table->foreignId('type_id');
            $table->foreignId('company_id');
            $table->foreignId('parent_work_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
