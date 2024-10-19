<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todo = new Todo();
        $todos = $todo->all();
        dd($todos);

        return view('todo.index'); //dd関数はLaravelのヘルパ関数であり、デバッグで用いる
    }                             //view関数はview('フォルダ名.ファイル名')
}
