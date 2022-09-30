<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlPath = Storage::path("db_insert.sql");

        $sqlCode = File::get($sqlPath);

        DB::connection()
            ->getPdo()
            ->exec($sqlCode);

        /*Schema::create('autos', function (Blueprint $table) {
            $table->id("A_ID");
            $table->string("A_S_ID")->default("");
            $table->integer("A_D_ID")->unsigned()->default(0);
            $table->integer("A_D_ACTION")->default(0);
            $table->integer("A_D_SORT")->default(0);
            $table->string("A_NOMER", 20)->default("");
            $table->string("A_RACE", 80);
            $table->date("A_RACE_DATE")->nullable();
            $table->string("A_COUNTRY", 2)->default("");
            $table->integer("A_PHONE_CODE")->default(0);
            $table->string("A_PHONE_NUMBER", 16)->default("0");
            $table->string("A_PROVIDER", 340)->default("");
            $table->string("A_DOC_CMR", 340)->default("");
            $table->string("A_DOC_PKCD", 340)->default("");
            $table->integer("A_CARGO_AUTO")->unsigned()->default(0);
            $table->integer("A_CARGO_TYPE")->unsigned()->default(0);
            $table->date("A_DATE")->nullable();
            $table->time("A_TIME")->nullable();
            $table->integer("A_STRATTIME")->default(0);
            $table->integer("A_FINISHTIME")->default(0);
            $table->date("A_BOOKING_DATE")->nullable();
            $table->time("A_BOOKING_TIME")->nullable();
            $table->date("A_DEADLINE_DATE")->nullable();
            $table->time("A_DEADLINE_TIME")->nullable();
            $table->text("A_DESC");
            $table->text("A_PRIM");
            $table->binary("A_CALLDRIVER_DATA")->nullable();
            $table->binary("A_NOTIDRIVER_DATA")->nullable();
            $table->text("A_SOTR_BADGE")->nullable();
            $table->text("A_PALLETSFORMATION")->nullable();
            $table->integer("A_LOCKMOVE")->default(0);
            $table->integer("A_TRAILER")->default(0);
            $table->integer("A_1C")->default(0);
            $table->integer("A_ZAKAZ")->default(0);
            $table->integer("A_THETIME")->default(0);
            $table->integer("A_STATUS")->default(0);

            $table->unique("A_NOMER, A_DATE, A_TIME", "NOMER_DATETIME");
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autos');
    }
}
