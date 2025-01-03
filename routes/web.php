<?php

use Illuminate\Support\Facades\Route; 

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth'])->prefix('manage')->name('manage')->group(function(){
        
        Route::prefix('xrac')->name('.xrac')->group(function(){

            //ROLE 
            include(__DIR__.'/manage/xrole.php'); 

            //BRANCH 
            include(__DIR__.'/manage/branch.php'); 


        });
    });
  
});