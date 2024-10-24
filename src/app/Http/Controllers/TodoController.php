<?php

namespace App\Http\Controllers; //namespaceはプロジェクトルートから見ての相対パス、所謂詳しい住所的なもの
                                //namespaceのおかげで、大阪の田中さんか東京の田中さんを区別している感じ

use App\Http\Requests\TodoRequest;
use App\Todo;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $todo) //Todoクラスをインスタンス化したものを$todoに代入
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

    public function store(TodoRequest $request) //(class名 $~~) メソッドインジェクション = classを自動でインスタンス化し$に代入
    {
        $inputs = $request->all();
        $this->todo->fill($inputs);
        $this->todo->save(); //data新規作成
        return redirect()->route('todo.index'); //リダイレクト先を名前付きルートのtodo.indexを指定
    }

    public function show($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.show', ['todo' => $todo]); //viewメソッドの第二引数で[show.blade.php内に渡す'変数名' => showメソッドの$todo]
    }

    public function edit($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.edit', ['todo' => $todo]);
    }

    public function update(TodoRequest $request, $id) // 第1引数: リクエスト情報の取得　第2引数: ルートパラメータの取得
    {
        // TODO: リクエストされた値を取得
        $inputs = $request->all();
        $todo = $this->todo->find($id);
        $todo->fill($inputs);
        $todo->save();
        return redirect()->route('todo.show', $todo->id);
    }

    public function delete($id)
    {
        $todo = $this->todo->find($id);
        $todo->delete();
        return redirect()->route('todo.index');
    }
}
