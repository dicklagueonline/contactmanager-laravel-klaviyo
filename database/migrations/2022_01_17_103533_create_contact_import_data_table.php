<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactImportDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_import_data', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('file_type');
            $table->string('file_extension');
            $table->integer('file_size')->default(0);
            $table->text('column_headers')->nullable();
            $table->text('fields')->nullable();
            $table->text('field_maps')->nullable();
            $table->integer('lines')->unsigned()->default(0);
            $table->timestamps(6);

            $table->foreignId('user_id')
                ->constrained('users')
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
        Schema::dropIfExists('contact_import_data');
    }
}
