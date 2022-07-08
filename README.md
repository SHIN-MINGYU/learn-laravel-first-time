# 1 日目　 database migration

1.  root folder の database/migrations の方で
    "php artisan make:migration create\_<テーブル名>\_table --create=<テーブル名>"という命令語を通じて作りたいデータベースのテーブルの migration ファイルを作る
2.  up の中の create 関数の 2 番目のアーギュメントのコルバック関数で作りたいデータベースの形を入力する
3.  使い終わったら"php artisan migrate"命令で自分のデータベース先ほど設定(.env file)しておいたデータベースに入れる
