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

        return view('todo.index', ['todos' => $todos]);
    }                             //view関数はview('フォルダ名.ファイル名')dd関数はLaravelのヘルパ関数であり、デバッグで用いる

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request) //(class名 $~~) メソッドインジェクション = classを自動でインスタンス化し$に代入
    {
        $content = $request->input('content'); //input('name属性')

        $todo = new Todo();
        $todo->content = $content; //Todoインスタンスのカラム名のプロパティに保存したい値を代入
        $todo->save(); //data新規作成

        return redirect()->route('todo.index'); //リダイレクト先を名前付きルートのtodo.indexを指定
    }
}
