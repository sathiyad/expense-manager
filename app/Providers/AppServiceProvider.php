<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('percentage', function ($attribute, $value, $parameters, $validator) {
            if ($parameters[0] === 'percentage') {
                $total = 0;
                foreach ($value as $item) {
                    $total += $item['percentage'];
                }
                if ($total !== 100) {
                    return false;
                }
            }
            return true;
        });
    }
}
