<?php

namespace iProtek\Xrac\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XuserCustomRoleAccess extends _CommonModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "app_account_id",
        "xrole_id",
        "xcontrol_access_id",
        "is_allow",

        "app_id",
        "branch_id",
        "data",
        "is_active",
        "cstyle",

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by"
    ];
    protected $casts = [
        "is_active"=>"boolean",
        "is_allow"=>"boolean"
    ];
}
