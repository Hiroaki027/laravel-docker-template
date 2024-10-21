# Laravel Lesson レビュー②

## Todo編集機能

### @method('PUT')を記述した行に何が出力されているか
* `<input type="hidden" name="method" value="PUT">`が出力されています。
つまりは、ここでHTTPメソッドを`PUT`として指定しています。

### findメソッドの引数に指定しているIDは何のIDか
* ルートパラメータのIDです。
```php
//index.blade.php
<a href="{{ route('todo.show', $todo->id) }}" class="btn btn-info ml-3">詳細</a>
```
上記の`$todo->id`で受け取ったidが
```php
//web.php
Route::get('/todo/{id}', 'TodoController@show')->name('todo.show');
```
`web.php`内の`'/todo/{id}'`に引き継がれ
```php
 public function show($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.show', ['todo' => $todo]);
    }
```
最終的に`show($id)`に代入されています。

### findメソッドで実行しているSQLは何か
* `select * from todos where id = "$id";`です

### findメソッドで取得できる値は何か
* 引数に該当するレコードデータです。
`find($id)`で`$id`=1の場合なら、idが1のレコード情報全てです。

### saveメソッドは何を基準にINSERTとUPDATEを切り替えているのか
* データベースに該当するレコードの有無で切り替えています。
具体的にはデータベースのテーブル内に`id`がない場合は、レコードを新規作成し
`id`が既に存在しているレコードには更新の処理をしています。

## Todo論理削除

### traitとclassの違いとは
* 大きな違いとしてはインスタンス化できるかできないかです。
`class`は`new class名`でインスタンス化できるのに対し
`trait`は`new tarait名`としてもインスタンス化できません。

### traitを使用するメリットとは
* `trait`のメリットとしてはクラスの継承をせずとも、他のクラスでも利用できることです。
つまりは、どのクラスからでも共通で呼び出せるメソッドやプロパティとなりますので、再利用しやすい特徴があります。

## その他

### TodoControllerクラスのコンストラクタはどのタイミングで実行されるか
* クラスがインスタンス化された時に実行しています。
```php
//Todocontroller.php
 public function __construct(Todo $todo) //Todoクラスをインスタンス化したものを$todoに代入
    {
        $this->todo = $todo;
    }
```
上記の記述では`$todo`に`Todo`クラスのインスタンスを代入しており
その`$todo`を`$this->todo`に代入している為、`$this->todo`左記の記述をするたびに
実行されています。

### RequestクラスからFormRequestクラスに変更した理由
* バリデーションを実装する為です。
`FormRequest`クラスに変更することで、`rules`メソッド内に処理を記述するだけで
バリデーションを設定できます。

### $errorsのhasメソッドの引数・返り値は何か
* `has`メソッドの引数はリクエストのパラメータ(入力欄の`'name'`属性)で返り値はbool型でtrueかfalseを返します。
引数のパラメータが存在していれば、trueを返し、なければfalseを返します。

### $errorsのfirstメソッドの引数・返り値は何か
* `first`メソッドの引数はリクエストのパラメータ(入力欄の`'name'`属性)で
返り値は、引数のバリューが返されています。
今回は`'name'`属性に`'content'`とあるのでそのバリューである
```php
//TodoRequest.php

public function rules()
    {
        return [
            'content' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            // 入力欄のname属性.ルール => メッセージ
            'content.required' => 'ToDoが入力されていません。',
            'content.max' => 'ToDoは :max 文字以内で入力してください。',
        ];
    }
```
`'ToDoが入力されていません。',`か`ToDoは :max 文字以内で入力してください。`が条件に合わせて
出力されます。

### フレームワークとは何か
* Webアプリケーションやシステム開発をするために必要な機能が揃っている枠組みです。

### MVCはどういったアーキテクチャか
* `Model View Controller`の略称であり、UIと内部データとを分けるソフトウェアアーキテクチャです。
ユーザーからのリクエストをコントローラーが受け取り、モデルに処理の実行を指示し
頼まれた処理を行ったモデルはその結果を、コントローラーを通じてビューに反映させています。

### ORMとは何か、またLaravelが使用しているORMは何か
* ORMは `Object-Relational Mapping`の略称です。
ORMがあることで、プログラミング言語と関係するデータベースの互換性を高めています。
つまりは、翻訳家のように間に入って、言いかえをしてくれています。
* Larabelで使用されているORMは、Eroquentです。

### composer.json, composer.lockとは何か
* `composer.json`は依存するパッケージを定義するファイルです。
`composer install`コマンドを使用することで、`composer.json`を元にパッケージがダウンロードされ
`vendor`ディレクトリの配下に置かれます。
* `composer.lock`は`composer.json`をインストール時に生成されるファイルです。
`composer.lock`がある場合は、`composer install`コマンドの参照先として、扱われます。
つまりは、`composer.json`は大元の初回インストール時に利用されるもので、パッケージが定義されているファイルの原本です。
一方で`composer.lock`はその原本の複製にあたり、複製がある場合は複製を参照するようになっています。

### composerでインストールしたパッケージ（ライブラリ）はどのディレクトリに格納されるのか
* `vendor`ディレクトリです。
