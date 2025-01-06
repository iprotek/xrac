<?php

use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Gate;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth'])->prefix('manage')->name('manage')->group(function(){
        
        Route::prefix('xrac')->name('.xrac')->group(function(){

            //ROLE ACCESS
            include(__DIR__.'/manage/xrole.php'); 

            //BRANCH 
            include(__DIR__.'/manage/branch.php'); 

            
            //ROLE 
            include(__DIR__.'/manage/role.php'); 
            /*
            Route::middleware([])->get('/set-xrac',function(){
                
                return \iProtek\Xrac\Helpers\XracHelper::getControlAccess();

                return \iProtek\Xrac\Helpers\XracHelper::setControlAccess([
                    [
                        "name"=>"name",
                        "title"=>"Title",
                        "description"=>"Desc",
                        "accesses"=>[
                            [
                                "name"=>"Access1",
                                "title"=>"Access Title",
                                "description"=>"Access Description"
                            ],
                            [
                                "name"=>"Access2",
                                "title"=>"Access Title3",
                                "description"=>"Access Description3"
                            ]
                        ]
                    ]
                ]);
            })->name('.set-xrac');
            /* */
            

        });
    });
  
});