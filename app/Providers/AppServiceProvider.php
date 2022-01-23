<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
//        DB::listen(fn($q) => logger($q->sql));
        Paginator::useBootstrap();

//        Gate::define("update-post",function (User $user,Post $post){
//           return $user->id === $post->user_id;
//        });

        Gate::before(function (User $user){
           if ($user->id === 1 ){
               return true;
           }
        });

    }
}
