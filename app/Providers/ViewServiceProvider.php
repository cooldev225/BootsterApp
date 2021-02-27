<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        // View::composer(
        //     'profile', 'App\Http\View\Composers\ProfileComposer'
        // );

        // Using Closure based composers...
        View::composer(
            [
                'frontend.layouts.dashboard',
                'frontend.home',
                'frontend.project',
                'frontend.group',
                'frontend.document',
                'frontend.task',
                'frontend.taskmap',
            ],
            'App\Http\Binds\DashboardComposer'
        );
    }
}
