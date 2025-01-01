<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXrolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xroles', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->integer('app_id')->nullable();
            //$table->integer('branch_id')->nullable();
            $table->integer('user_type_id')->nullable();
            $table->integer('priority_id')->nullable();
            $table->integer('order_id')->default(0);
            $table->longText('data')->nullable();
            $table->boolean('is_active')->default(1);
            $table->longText('cstyle')->nullable();


            $table->bigInteger('group_id');
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();
            $table->softDeletes(); 
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
        Schema::dropIfExists('xroles');
    }
}
