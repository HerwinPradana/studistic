<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAssignmentAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment_answers', function (Blueprint $table) {
            Schema::rename('assignment_answers', 'assignment_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignment_options', function (Blueprint $table) {
            Schema::rename('assignment_options', 'assignment_answers');
        });
    }
}
