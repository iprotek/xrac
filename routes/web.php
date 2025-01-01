<?php

use Illuminate\Support\Facades\Route; 
use iProtek\SmsSender\Http\Controllers\SmsController;
use iProtek\SmsSender\Http\Controllers\SmsTicketController;
use iProtek\SmsSender\Http\Controllers\SmsTicketMessageController;
use iProtek\SmsSender\Http\Controllers\MessageController;
use iProtek\SmsSender\Http\Controllers\SmsClientApiRequestLinkController;
use iProtek\SmsSender\Http\Controllers\SmsClientMessageController;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
    Route::middleware(['auth'])->prefix('manage')->name('manage')->group(function(){
        
        Route::prefix('xrole')->name('.xrole')->group(function(){

            //MESSAGE CHAT NOTIFICATIONS 


        });
    });
  
});