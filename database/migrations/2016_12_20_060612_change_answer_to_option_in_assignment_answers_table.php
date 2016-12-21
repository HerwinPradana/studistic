<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnswerToOptionInAssignmentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment_answers', function (Blueprint $table) {
        	$table->dropColumn('answer_id');
            $table->integer('option_id')->after('question_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignment_answers', function (Blueprint $table) {
            //
        });
    }
}
