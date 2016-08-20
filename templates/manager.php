<?php

namespace App\Bots;

use SumanIon\TelegramBot\Manager;

class {{name}} extends Manager
{
    /**
     * Actions are the best way to make the bot interactive.
     *
     * @var array
     */
    protected $actions = [
        // Actions\Action::class
    ];

    /**
     * API token for the bot used be able to make API requests.
     *
     * @return string
     */
    public function token()
    {
        return '';
    }

    /**
     * This method is triggered when new bot user is registered.
     *
     * @param  \SumanIon\TelegramBot\TelegramBotUser $user
     *
     * @return void
     */
    public function onNewUser($user)
    {
        //
    }
}