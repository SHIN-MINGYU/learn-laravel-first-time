<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

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
    {
        $user = \auth()->user();
        // メモ一覧を取得
        //　ララベルでデータベースのクエリの仕方
        $memos = MEMO::where('user_id',$user['id'])->where('status',1)->orderBy('updated_at','DESC')->get();
        return view('home',compact('user','memos'));
    }
    public function create(){
        //ログインしているユーザーの情報をViewに渡す
        $user =\auth()->user();
        return view('create',compact('user'));
    }
    public function store(Request $request){
        $data = $request->all();
        // POSTされたデータをDBに挿入
        // メモモデルにDBへ保存する命令を出す
        $memo_id = MEMO::insertGetId(['content'=>$data['content'],'user_id'=>$data['user_id'],'status'=>1]);

        // リダイレクト処理
        return redirect()->route('home');
    }
    public function edit($id){
        //ルートで波かっこで包んだidの部分が引数としてコントローラに渡される
        $user = \auth()->user();
        $memos = MEMO::where('user_id',$user['id'])->where('status',1)->orderBy('updated_at','DESC')->get();
        $memo = MEMO::where('status',1)->where('id',$id)->where('user_id',$user['id'])
        ->first();
        //firstメソッドとは？
        //条件に該当したものの中で1行だけ取り返すメソッド
        return view('edit',compact('memo','user','memos'));
    }
}
