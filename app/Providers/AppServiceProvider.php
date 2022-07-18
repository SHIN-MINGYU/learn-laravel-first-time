<?php

namespace App\Providers;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //　全てのメッソドが呼ばれる前に先に呼ばれるメッソド
        view()->composer('*',function($view){
            $user = auth()->user();
            $memoModel = new Memo();
            $memos = $memoModel->myMemo(auth()->id());

            $tagModel = new Tag();
            $tags = $tagModel->where('user_id',auth()->id())->get();
            $view->with('user',$user)->with('memos',$memos)->with('tags',$tags);
        });
    }
}
