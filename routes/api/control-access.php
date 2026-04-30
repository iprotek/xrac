<?php
use iProtek\Xrac\Http\Controllers\XcontrolAccessController;
use iProtek\Xrac\Http\Controllers\XcontrolAccessDefaultController;
use Illuminate\Http\Request;
use iProtek\Xrac\Helpers\XracPayHttp;
use iProtek\Core\Helpers\PayHttp;
use \iProtek\Xrac\Helpers\XracHelper;


    Route::prefix('control-access')->name('.control-access')->group(function(){
        Route::get('list',[
            "uses"=>function(Request $request){ 
                return XracHelper::getControlAccess();
            },
            "description"=>"List of control access",
            "is_visible"=>false,
            "is_allow"=>false
        ])->name('.list');

        Route::get('allowed-default-role-list/{role_id}', [
            "uses"=>[XcontrolAccessDefaultController::class, 'allow_role_access_list'],
            "description"=>"Control Access that has Default allowed role list",
            "is_visible"=>false,
            "is_allow"=>false
        ])->name('.role-list');

        Route::post('update-default-role-access-list/{role_id}', [
            "uses"=>[XcontrolAccessDefaultController::class, 'update_allow_role_access'],
            "description"=>"Update access control of the default role access list",
            "is_visible"=>false,
            "is_allow"=>false
        ])->name('.update-default-role-access-list');

        Route::get('check-gate/{access_name}', [ "uses"=>function(Request $request, $access_name){
                return [
                    "name"=>$access_name,
                    "is_allow"=>auth()->user()->can($access_name)
                ];

            },
            "description"=>"Control Access gate checker",
            "is_visible"=>false,
            "is_allow"=>false
        ])->name('.gate');

    });

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