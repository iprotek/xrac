<?php

namespace iProtek\Xrac\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iProtek\Core\Http\Controllers\_Common\_CommonOwnGroupController;

class XroleController extends _CommonOwnGroupController
{
    //
    public $guard = 'admin';

    public function index(Request $request){

        return $this->view('iprotek_xrac::manage.xrole');

    }

    public function user_role_access(Request $request){
        return $this->view('iprotek_xrac::manage.xuser-role-access');
    }

}
