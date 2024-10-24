<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    protected $table = 'todos'; //$tableプロパティ　Eloquementモデルのプロパティの1つ　関連付けるターブル名を指定

    protected $fillable = [ //$fillableで許可する項目を記載
        'content',
    ];
}
