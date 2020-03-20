<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInConversions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversions', function (Blueprint $table) {
            $table->renameColumn('file_original_name', 'original_file_name');
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
            $table->renameColumn('original_file_name', 'file_original_name');
        });
    }
}
