<?php
use iProtek\Xrac\Http\Controllers\XroleController;


Route::prefix('xrole')->name('.xrole')->group(function(){

    Route::get('/', [ XroleController::class, 'index' ])->name('.index');
    Route::get('/user-role-access', [ XroleController::class, 'user_role_access' ])->name('.user-role-access');

});
