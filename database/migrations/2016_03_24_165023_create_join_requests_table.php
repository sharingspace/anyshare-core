<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoinRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_join_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('community_id');
            $table->text('message')->nullable()->default(NULL);
            $table->date('approved_at')->nullable()->default(NULL);
            $table->integer('approved_by')->nullable()->default(NULL);
            $table->date('rejected_at')->nullable()->default(NULL);
            $table->integer('rejected_by')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_join_requests');
    }
}
