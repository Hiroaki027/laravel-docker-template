<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todos';

    protected $fillable = [ //$fillableで許可する項目を記載
        'content',
    ];
}
