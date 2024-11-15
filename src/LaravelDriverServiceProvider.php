<?php

namespace RobKerry\EmailitLaravelDriver;

use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use RobKerry\EmailitLaravelDriver\EmailitTransport;

class LaravelDriverServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(MailManager::class)->extend('emailit', function (array $config) {
            $config = array_merge($this->app['config']->get('emailit', []), $config);

            $emailit = [
                'api_key' => Arr::get($config, 'api_key'),
                'host' => Arr::get($config, 'host'),
                'protocol' => Arr::get($config, 'protocol'),
                'api_path' => Arr::get($config, 'api_path'),
            ];
            return new EmailitTransport($emailit);
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-driver.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/emailit.php', 'emailit');
    }
}
