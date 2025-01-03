<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XcontrolAccess extends _CommonModel
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        "xcontrol_id",
        "name",
        "title",
        "description",
        "order_id",
        "app_id",
        "data",
        "is_active",
        "cstyle",

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by"
    ];
}
