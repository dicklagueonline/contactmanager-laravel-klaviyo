<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlaviyoProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klaviyo_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('person_id');
            $table->string('contact_list_id')->nullable();

            $table->timestamps(6);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('contact_id')
                ->nullable()
                ->constrained('contacts')
                ->onDelete('cascade');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klaviyo_profiles');
    }
}
