<?php

use Illuminate\Support\Facades\Route; 
use iProtek\Core\Http\Controllers\Manage\FileUploadController; 
use iProtek\Core\Http\Controllers\AppVariableController;
use iProtek\SmsSender\Http\Controllers\MessageController;
use iProtek\SmsSender\Http\Controllers\SmsClientApiRequestLinkController;

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});
Route::prefix('api')->middleware('api')->name('api')->group(function(){ 

    Route::prefix('xrac')->name('.xrac')->group(function(){

      Route::prefix('group/{group_id}')->middleware(['pay.api', 'policy.control'])->group(function(){ 
      
        //BRANCH
        include(__DIR__.'/api/branch.php'); 
        
        //CONTROL ACCESS
        include(__DIR__.'/api/control-access.php'); 

        //ROLE
        include(__DIR__.'/api/role.php'); 

        //USER ROLE
        include(__DIR__.'/api/user-role.php'); 

        //XROLE
        include(__DIR__.'/api/xrole.php'); 
      
      });

    });
  
  }); 
