<?php

use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Gate;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth:admin'])->prefix('manage')->name('manage')->group(function(){
        
        Route::prefix('xrac')->name('.xrac')->group(function(){

            //ROLE ACCESS
            include(__DIR__.'/api/xrole.php'); 

            //BRANCH 
            include(__DIR__.'/api/branch.php'); 

            
            //ROLE 
            include(__DIR__.'/api/role.php');  
            
            //ROLE CONTROL ACCESS 
            include(__DIR__.'/api/control-access.php');  
            
            //USER ROLE CONTROL ACCESS 
            include(__DIR__.'/api/user-role.php'); 

        });
    });
  
});