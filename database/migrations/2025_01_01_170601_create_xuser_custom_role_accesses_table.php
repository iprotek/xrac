<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXuserCustomRoleAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xuser_custom_role_accesses', function (Blueprint $table) {
            $table->id();

            
            $table->integer('app_account_id');
            $table->integer('xrole_id');
            $table->boolean('xcontrol_access_id'); 
            $table->integer('is_allow'); // 0-No, 1-Yes, 2-Request

            
            $table->integer('app_id')->default(0);
            $table->integer('branch_id')->default(0);
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
        Schema::dropIfExists('xuser_custom_role_accesses');
    }
}
