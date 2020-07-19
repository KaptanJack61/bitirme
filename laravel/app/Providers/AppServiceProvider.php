<?php

namespace App\Providers;


use Cache;
use Carbon\Carbon;
use Helpers;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        setlocale(LC_ALL, "tr_TR.UTF-8");

        Carbon::setLocale(config('app.locale'));

        $neighborhoods = $this->getNeighborhoods();
        $statuses = $this->getStatuses();

        View::share([
            'neighborhoods' => $neighborhoods,
            'statuses' => $statuses
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getNeighborhoods(){
        $neighborhoods = null;

        if (Cache::has('neighborhoods')){
            $neighborhoods = Cache::get('neighborhoods');
            return $neighborhoods;

        }else{
            $neighborhoods = Helpers::getNeighborhoods();
            Cache::forever('neighborhoods', $neighborhoods);
            return $neighborhoods;
        }
    }

    private function getStatuses(){
        $statuses = null;

        if (Cache::has('statuses')){
            $statuses = Cache::get('statuses');
            return $statuses;

        }else{
            $statuses = Helpers::getStatus();
            Cache::forever('statuses', $statuses);
            return $statuses;
        }
    }
}
