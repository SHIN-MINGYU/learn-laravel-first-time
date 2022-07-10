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
        return view('home');
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
}
