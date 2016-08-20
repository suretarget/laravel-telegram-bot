<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\TelegramBot;

trait ReferencesBotModel
{
    /**
     * Bot model.
     *
     * @var \SumanIon\TelegramBot\TelegramBot
     */
    protected $bot;

    /**
     * Makes the bot model available in the class.
     *
     * @param TelegramBot $bot
     */
    public function __construct(TelegramBot $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Makes the bot model available anywhere.
     *
     * @return \SumanIon\TelegramBot\TelegramBot
     */
    public function bot()
    {
        return $this->bot;
    }
}