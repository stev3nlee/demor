<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Models\Page;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $page=new page;
      View::share([
        "currencies"=>$page->getActiveCurrency(),
      ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
