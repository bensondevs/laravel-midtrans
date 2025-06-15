<?php

namespace Bensondevs\Midtrans;

use Illuminate\Support\ServiceProvider;

class MidtransServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configure();

        $this->registerPublishing();
    }

    protected function configure(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/midtrans.php',
            'midtrans',
        );
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__.'/../config/midtrans.php' => $this->app->configPath('midtrans.php')],
                'midtrans-config',
            );

            $this->publishes([
                __DIR__.'/../database/migrations/create_gopay_accounts_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_gopay_accounts_table.php'),
                __DIR__.'/../database/migrations/create_registered_cards_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_registered_cards_table.php'),
            ], 'midtrans-migrations');
        }
    }
}
