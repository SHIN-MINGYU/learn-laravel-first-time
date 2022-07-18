<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {/* 
        元々こう書いていた変数をprovidersでview composerを使うことでコードの量を減らせる
        $user = \auth()->user();
        // メモ一覧を取得
        //　ララベルでデータベースのクエリの仕方
        $memos = MEMO::where('user_id',$user['id'])->where('status',1)->orderBy('updated_at','DESC')->get(); */
        return view('create'); 
    }


    public function create(){
        // ログインしているユーザーの情報をViewに渡す
        return view('create');
    }


    public function store(Request $request){
        $data = $request->all();
        // POSTされたデータをDBに挿入
        // メモモデルにDBへ保存する命令を出す

        // 同じタグがあるかチェック
        $exist_tag = Tag::where(['name'=>$data['tag'],'user_id'=>$data['user_id']])->first();
        
        if(empty($exist_tag)){
            //　先にタグをインサート
            $tag_id = Tag::insertGetId(['name'=>$data['tag'],'user_id'=>$data['user_id']]);
        }else{
            $tag_id = $exist_tag;
        }


        // タグIDが判明する
        // タグIDをmemosテーブルに入れてあげる

        $memo_id = MEMO::insertGetId([
            'content'=>$data['content'],
            'user_id'=>$data['user_id'],
            'tag_id'=>$tag_id,
            'status'=>1]);

        // リダイレクト処理
        return redirect()->route('home');
    }


    public function edit($id){
        $user = auth()->user();
        $memo = MEMO::where('status',1)->where('id',$id)->where('user_id',$user['id'])->first();

        // firstメソッドとは？
        // 条件に該当したものの中で1行だけ取り返すメソッド
        return view('edit',compact('memo'));
    }

    public function update(Request $request,$id){
        $inputs = $request->all();
        Memo::where('id',$id)->update(['content' => $inputs['content'], 
        'tag_id'=>$inputs['tag_id']]);
        return redirect()->route('home');
    }

    public function delete($id){


        //論理削除なので　status=２
        Memo::where('id',$id)->update(['status' => 2]);
        /* 
        物理削除
        Memo::where('id',$id)->delete();
         */

         // with を使えばsuccessという変数値をもつsessionが一回生まれる 
        return redirect()->route('home')->with('success',"メモの削除が完了しました！");
    }
}
