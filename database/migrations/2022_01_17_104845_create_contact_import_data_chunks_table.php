<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactImportDataChunksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_import_data_chunks', function (Blueprint $table) {
            $table->id();
            $table->longText('chunk_data');
            $table->integer('processed')->unsigned()->default(0);
            $table->integer('saved')->unsigned()->default(0);
            $table->integer('unsaved')->unsigned()->default(0);
            $table->boolean('is_finished')->default(false);
            $table->timestamps();

            $table->foreignId('contact_import_data_id')
                ->constrained('contact_import_data')
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
        Schema::dropIfExists('contact_import_data_chunks');
    }
}
