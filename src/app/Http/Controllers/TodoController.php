<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('todo.index'); //dd関数はLaravelのヘルパ関数であり、デバッグで用いる　
    }                             //view関数はview('フォルダ名.ファイル名')
}
