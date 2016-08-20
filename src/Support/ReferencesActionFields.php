<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;
use SumanIon\TelegramBot\Manager;
use SumanIon\TelegramBot\TelegramBot;
use SumanIon\TelegramBot\TelegramBotUser;

trait ReferencesActionFields
{
    /**
     * User which created the update.
     *
     * @var \SumanIon\TelegramBot\TelegramBotUser
     */
    protected $user;

    /**
     * Update for which the actions are executed.
     *
     * @var \SumanIon\TelegramBot\Update
     */
    protected $update;

    /**
     * Bot which received the update.
     *
     * @var \SumanIon\TelegramBot\TelegramBot
     */
    protected $bot;

    /**
     * Bot manager.
     *
     * @var \SumanIon\TelegramBot\Manager
     */
    protected $manager;

    /**
     * Reference fields used by an action.
     *
     * @param Update $update
     */
    public function __construct(
        TelegramBotUser $user,
        Update $update,
        TelegramBot $bot,
        Manager $manager)
    {
        $this->user    = $user;
        $this->update  = $update;
        $this->bot     = $bot;
        $this->manager = $manager;
    }
}