<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add 'created_by' column to the 'allocations' table
        Schema::table('allocations', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by');
        });

        // Add 'created_by' column to the 'inventory' table
        Schema::table('inventory', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by');
        });

        // Add 'created_by' column to the 'project_budgets' table
        Schema::table('project_budgets', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by');
        });

        // Add 'created_by' column to the 'requisitions' table
        Schema::table('requisitions', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
