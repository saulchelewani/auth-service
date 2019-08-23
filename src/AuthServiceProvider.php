<?php

namespace TNM\AuthService;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Laravel\Passport\Passport;
use TNM\AuthService\Http\Middleware\Authorize;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/auth_server.php', 'auth_server');

        Passport::routes();

        Response::macro('success', function (array $data, string $key = 'data') {
            return Response::json([
                'message' => 'Action completed successfully',
                'errors' => null,
                "$key" => $data
            ]);
        });

    }

    public function register()
    {
        app('router')->aliasMiddleware('permits', Authorize::class);
    }
}
