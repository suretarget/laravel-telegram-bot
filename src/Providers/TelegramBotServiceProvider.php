<?php

namespace SumanIon\TelegramBot\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Custom artisan commands.
     *
     * @var array
     */
    protected $commands = [
        \SumanIon\TelegramBot\Commands\CreateBotManagers::class,
        \SumanIon\TelegramBot\Commands\RegisterNewBots::class,
        \SumanIon\TelegramBot\Commands\DeleteBots::class,
        \SumanIon\TelegramBot\Commands\ManageWebhooks::class,
        \SumanIon\TelegramBot\Commands\CreateBotActions::class,
        \SumanIon\TelegramBot\Commands\ManageBotUserPermissions::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
        $this->loadCustomRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Load custom API routes.
     *
     * @return void
     */
    public function loadCustomRoutes()
    {
        if (!$this->app->routesAreCached()) {

            Route::group([
                'middleware' => ['api'],
                'namespace' => 'SumanIon\TelegramBot\Controllers',
                'prefix' => 'api',
            ], function () {
                require __DIR__ . '/../../routes/api.php';
            });
        }
    }
}
