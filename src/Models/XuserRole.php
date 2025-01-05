<?php

namespace iProtek\Xrac\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XuserRole extends _CommonModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_admin_id",
        "xrole_id",
        "is_default",
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
}
