<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCorrectInAssignmentOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment_options', function (Blueprint $table) {
            $table->smallInteger('order')->default(1)->after('question_id');
            $table->boolean('is_correct')->default(0)->after('text');
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
            //
        });
    }
}
