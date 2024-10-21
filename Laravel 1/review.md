# Laravel Lesson レビュー①

## Todo一覧機能

### Todoモデルのallメソッドで実行しているSQLは何か
* `select * from todos;` です。
つまり、モデル内のレコード全てを取得しています。

### Todoモデルのallメソッドの返り値は何か
* `Illuminate\Database\Eloquent\Collection`クラスのインスタンスです。
仕様として、`Illuminate\Support\Collection`クラスを拡張している為
上記のインスタンスでもallメソッドが利用できます。

### 配列の代わりにCollectionクラスを使用するメリットは
* `Collection`クラスのメリットしては新しく`Collection`インスタンスを返している為
メソッドチェーンを利用できることです。

### view関数の第1・第2引数の指定と何をしているか
* 第1引数では、todoフォルダのindex.blade.phpファイルを指定し
第2引数には渡したいデータを指定しています。
```php
  return view('todo.index', ['todos' => $todos]);
```
今回は、渡したいデータとして連想配列で['blade内での変数'　=> '代入したい値']を指定しています。

* view関数そのものは、Controllerからbladeファイルへデータを渡すための記述となります。

### index.blade.phpの$todos・$todoに代入されているものは何か
* モデル内の全レコードが代入されています。
```php
//index.blade.php

@foreach ($todos as $todo)
```
```php　
//TodoContoroller.php

  public function index()
    {
        $todo = new Todo();
        $todos = $todo->all();
        return view('todo.index', ['todos' => $todos]);
    }
```
```php
class Todo extends Model
```
上記の記述を要約すると、`index.blade.php内の$todo = Todo::all()`となる為、Todoモデルのレコード全てとなります。
ただし、今回はTodoモデルを直で呼び出しているわけではなくTodoインスタンスからallメソッドを呼び出している為
正確には記述として成り立ちませんが、`index.blade.php内の$todo = new Todo->all()`となります。

## Todo作成機能

### Requestクラスのallメソッドは何をしているか
* HTTPリクエスト情報の全てを連想配列で取得しています。

### fillメソッドは何をしているか
* 連想配列で取得した値の各プロパティに一括で代入しています。

### $fillableは何のために設定しているか
* fillメソッドでモデルに代入可能なプロパティに制限を設けている。
今回はfillメソッドで代入できるものは`content`カラムと設定することで
`content`カラム以外は外部から、変更ができなくなります。

### saveメソッドで実行しているSQLは何か
* `insert into todos ("content") VALUES ("$inputs");`です。

### redirect()->route()は何をしているか
* リダイレクト先を指定しています。
`redirect()`では`Illuminate\Routing\Redirector`インスタンスが返されており、その後に
`route()`メソッドの引数にリダイレクト先を指定しています。

## その他

### テーブル構成をマイグレーションファイルで管理するメリット
* マイグレーションファイルを共有しておけば、テーブルの構成を
マイグレーション実行するだけで統一させられる点です。

### マイグレーションファイルのup()、down()は何のコマンドを実行した時に呼び出されるのか
* マイグレーションファイルのup()は`php artisan migrate`を実行した時です。
マイグレーションファイルのdown()は`php artisan migrate:rollback`を実行した時です。

### Seederクラスの役割は何か
* データベース内にレコードを挿入することです。

### route関数の引数・返り値・使用するメリット
* route関数の引数はルート名で、返り値としてはURL文字列となっています。
また、引数に名前付きルートを用いることで、URLに変更があったとしても
ルート名さえ変更しなければ修正箇所が減る点がメリットとしてあります。

### @extends・@section・@yieldの関係性とbladeを分割するメリット
* @extends()で親ファイルを指定し、継承しています。
* @section()では、親ファイルの@yield()に値を渡しています。
@endsectionを記載し、渡す範囲を決めています。
* メリットとしては親ファイルに、他のファイルで重なる共通の記述を書くことで
子ファイルの記述が削減できることです。

### @csrfは何のための記述か
* csrf対策の為の記述です。
また、この記述がなければトークンの付与がされない為、ページ遷移時に無効なページと判断されます。

### {{ }}とは何の省略系か
* `<?php echo ?>`もしくは`<?= ?>`の省略系です。
