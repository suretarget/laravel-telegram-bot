<?php

namespace SumanIon\TelegramBot;

abstract class Action
{
    use Support\ReferencesActionFields;
    use Support\ProxiesManagerMethods;
    use Support\KnowsMultipleResponseTypes;
    use Support\StopsActions;

    /**
     * Execute the action.
     *
     * @return void
     */
    abstract public function handle();
}