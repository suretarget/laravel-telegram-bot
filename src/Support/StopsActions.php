<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Exceptions\StopActions;

trait StopsActions
{
    /**
     * All remaining actions for the update won't run.
     *
     * @return void
     */
    public function stop()
    {
        throw new StopActions;
    }
}