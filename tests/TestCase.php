<?php

namespace Bensondevs\Midtrans\Tests;

use Bensondevs\Midtrans\MidtransServiceProvider;
use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MidtransServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        $envPath = dirname(__DIR__);
        if (file_exists($envPath . '/.env')) {
            Dotenv::createImmutable($envPath)->safeLoad();
        }

        config()->set('midtrans.mode', 'sandbox');
        config()->set('midtrans.sandbox', [
            'api_url' => 'https://api.sandbox.midtrans.com/',
            'snap_url' => 'https://app.sandbox.midtrans.com/snap/',
            'server_key' => env('MIDTRANS_SANDBOX_SERVER_KEY'),
            'client_key' => env('MIDTRANS_SANDBOX_CLIENT_KEY'),
        ]);

        $migrationFiles = [
            'create_gopay_accounts_table',
            'create_registered_cards_table',
        ];

        foreach ($migrationFiles as $migrationFile) {
            $migration = include __DIR__."/../database/migrations/$migrationFile.php";

            $migration->up();
        }
    }
}
