<?php

namespace Openpesa\Pesa;

use Illuminate\Support\Facades\Config;
use Openpesa\SDK\Pesa;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PesaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-pesa')
            ->hasConfigFile('laravel-pesa');
    }

    public function packageRegistered()
    {
        $this->app->singleton('pesa', function () {
            $publicKey = Config::get('laravel-pesa.public_key');

            $apiKey = Config::get('laravel-pesa.api_key');
            $env = Config::get('laravel-pesa.env');

            if (is_null($publicKey)) {
                throw new \Exception('Please provide a public key in the config file');
            }
            if (is_null($apiKey)) {
                throw new \Exception('Please provide an api key in the config file');
            }

            return new Pesa([
                'api_key' => $apiKey,
                'public_key' => $publicKey,
                'env' => $env,
            ]);
        });
    }
}
