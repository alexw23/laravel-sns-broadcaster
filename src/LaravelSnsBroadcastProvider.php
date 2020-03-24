<?php

namespace MaxGaurav\LaravelSnsBroadcaster;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LaravelSnsBroadcastProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws
     */
    public function boot()
    {
        $this->app->make(BroadcastManager::class)->extend('sns', function ($app, $config) {
            $client = new SnsClient([
                'version' => '2010-03-31',
                'region' => $config['config']['region'],
                'credentials' => new Credentials(
                    $config['config']['key'],
                    $config['config']['secret']
                )
            ]);

            return new SnsBroadcaster(
                $client,
                $config['config']['arn-prefix'],
                $config['config']['suffix']
            );
        });
    }
}