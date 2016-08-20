<?php

namespace SumanIon\TelegramBot;

abstract class Manager
{
    use Support\Logger;
    use Support\ReferencesBotModel;
    use Support\SendsApiRequests;
    use Support\ManagesUpdates;
    use Support\ManagesWebhooks;
    use Support\NotifiesAllUsers;

    /**
     * Actions are the best way to make the bot interactive.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * API token for the bot used to be able to make API requests.
     *
     * @return string
     */
    abstract public function token();
}