<?php

namespace Masoudi\Nova\Tool\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group_label'
    ];
}
