# 1 日目　 database migration

1.  root folder の database/migrations の方で
    "php artisan make:migration create\_<テーブル名>\_table --create=<テーブル名>"という命令語を通じて作りたいデータベースのテーブルの migration ファイルを作る
2.  up の中の create 関数の 2 番目のアーギュメントのコルバック関数で作りたいデータベースの形を入力する
3.  使い終わったら"php artisan migrate"命令で自分のデータベース先ほど設定(.env file)しておいたデータベースに入れる

ここで作られたマイグレーションファイルの中には up と down で分かれるがここで up は migration を行う時の動作を down は roleback を行う動作をする

# 2 日目

## 2-1 ララベル ui の導入

    >composer require laravel/ui
    >php artisan ui <language> --auth
    >npm install && npm run dev

できない場合はコンポーザーの問題ですから composer self-update --1 コマンドとして update を行う</br>
もしインストール中にメモリエラーが起きたら php フォルダーに行って php.ini の中のメモリ制限を-1 に切り替える</br>
php.ini の中に extension=php_fileinfo という extension も要りますので追加してまた php --ini コマンドを入力</br>

## 2-2 ララベルスタート

    php artisan serve

## 2-3 ララベルビューのモヂュール化

    @extends('layout.app')

=> layout folder の app.blade.php を親ファイルにする

    @section('key') ~ @endsection

=> 親ファイルで使うとき<span style="color:green">@yield</span>コマンドで呼ばれる範囲

## 2-3 ララベルのルーティン

一般的に routes folder の web.php で行う<br>

そしてページの中に必須的に必要な情報があったら routes を指定してくれるコントローラから
compact メッソドを view の二番目のアーギュメントとして渡して呼ぶことで blade.php ファイルで使える<br>
この時 blade ファイルの中で先ほど渡された情報を使うには{{}}の中で入力しないといけない<br>
dd(variables)といメッソドはデバッグの時非常に有用なので覚えておこう！</br>

そして Contoroler のパラメータで Request type の$request という変数を書くことで request された情報を習得できる<br>

    php artisan make:model Memo

と

    use Memo

コマンドでもっと楽にデータベースを使える

# 3 　日目

## 3-1 ララベルでのデータベースクエリの仕方

例

    $memos = MEMO::where('user_id',$user['id'])->where('status',1)->orderBy('updated_at','DESC')->get();

このようにメモというデータベースモデルをつくたらララベルはそのクラスの中に query の property を持っているようだ

## 3-2 blade.php でコントローラからもらった情報を表示

波かっこ二つで包んで変数を書いたらその情報が html 上に現れる
例

    @foreach($memos as $memo)
        <p>{{$memo['content]}}</p>
    @endforeach

## 3-4 ララベルのルートのパラメータ

    routes/web.phpのファイルのurlの部分にパラメーターとして波かっこで包まれた部分はコントローラに渡される時引数として渡される
    例
        Route::get('/edit/{id}',[HomeController::class,'edit'])->name('edit');
        ->
        public function edit(id){
            ... some code
        }

## 3-4 blade.php の url 書き方

route('name') このように url を入力するとララベルは route フォルダでその url を探して返してあげる作業をする

例

    <form method = "POST" action ="{{ route('update',['id' => memo['id] ] )}}"></form>

=>return 値 :　/edit/{id}
