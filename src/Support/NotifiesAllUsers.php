<?php

namespace SumanIon\TelegramBot\Support;

trait NotifiesAllUsers
{
    /**
     * Send notifications to all bot users.
     *
     * @param  mixed  $mixed
     * @param  array  $options
     *
     * @return void
     */
    public function notify($mixed, $options = [])
    {
        if (is_callable($mixed)) {
            foreach ($this->bot->users as $user) {
                if (false === $mixed($user, $this, $options)) {
                    break;
                }
            }
        } else {
            foreach ($this->bot->users as $user) {
                $this->sendMessage($user, $mixed, $options);
            }
        }
    }
}