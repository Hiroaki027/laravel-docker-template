<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function index()
    {
        $todos = $this->todo->all();
        return view('todo.index', ['todos' => $todos]);
    }                             //view関数はview('フォルダ名.ファイル名')dd関数はLaravelのヘルパ関数であり、デバッグで用いる

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request) //(class名 $~~) メソッドインジェクション = classを自動でインスタンス化し$に代入
    {
        $inputs = $request->all();

        $this->todo->fill($inputs);
        $this->todo->save(); //data新規作成

        return redirect()->route('todo.index'); //リダイレクト先を名前付きルートのtodo.indexを指定
    }

    public function show($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.show', ['todo' => $todo]);
    }

    public function edit($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.edit', ['todo' => $todo]);
    }
}
