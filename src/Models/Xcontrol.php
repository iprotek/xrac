<?php

namespace iProtek\Xrac\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Xcontrol extends _CommonModel
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        "name",
        "title",
        "description",
        "app_id",
        "user_type_id",
        "priority_id",
        "order_id",
        "data",
        "is_active",
        "cstyle",

        "group_id",
        "pay_created_by",
        "pay_updated_by",
        "pay_deleted_by"


    ];


}
