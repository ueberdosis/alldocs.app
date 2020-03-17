<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsInConversions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversions', function (Blueprint $table) {
            $table->renameColumn('hashId', 'hash_id');
            $table->renameColumn('FileOriginalName', 'file_original_name');
            $table->renameColumn('fileExtension', 'file_extension');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversions', function (Blueprint $table) {
            $table->renameColumn('hash_id', 'hashId');
            $table->renameColumn('file_original_name', 'FileOriginalName');
            $table->renameColumn('file_extension', 'fileExtension');
        });
    }
}
