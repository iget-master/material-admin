<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use IgetMaster\MaterialAdmin\Models\Draft;

class RemoveDraftColumnsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drafts', function (Blueprint $table) {
            $table->json('columns');
        });

        Draft::query()->select('id')->chunk(10, function($drafts) {
            foreach ($drafts as $draft) {
                $columns = [];
                foreach (\IgetMaster\MaterialAdmin\Models\DraftColumn::where('draft_id', $draft->id)->get() as $column) {
                    $columns[$column->column] = $column->value;
                }

                $draft->columns = $columns;
                $draft->save();
            }
        });

        Schema::drop('draft_columns');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}