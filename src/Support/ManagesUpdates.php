<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;
use SumanIon\TelegramBot\Exceptions\SkipAction;
use SumanIon\TelegramBot\Exceptions\StopActions;

trait ManagesUpdates
{
    use ManagesBotUsers;
    use ManagesStates;

    /**
     * Get all new bot updates.
     *
     * @return void
     */
    public function getUpdates()
    {
        $offset = $this->bot->offset;
        $response = $this->sendRequest('getUpdates', [
            'offset' => $offset + 1
        ]);

        if (!$response or !count($response->result)) {
            return [];
        }

        foreach ($response->result as $update) {
            $offset = $update->update_id;
            yield new Update($update);
        }

        $this->bot->offset = $offset;
        $this->bot->save();
    }

    /**
     * Process all new updates.
     *
     * @param  mixed  $updates
     *
     * @return void
     */
    public function handleUpdates($updates)
    {
        foreach ($updates as $update) {
            $this->handleUpdate($update);
        }
    }

    /**
     * Execute all actions for an update.
     *
     * @param  Update $update
     *
     * @return void
     */
    public function handleUpdate(Update $update)
    {
        $user = $this->getBotUser($update);

        foreach ((array)$this->actions as $action) {

            try {
                (new $action($user, $update, $this->bot, $this))->handle();
            } catch (SkipAction $ex) {
                continue;
            } catch (StopActions $ex) {
                break;
            } catch (Exception $ex) {
                throw $ex;
            }

        }

        $this->saveState($user);
    }
}