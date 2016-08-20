<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;

trait ManagesBotUsers
{
    /**
     * Get user which created the update.
     *
     * @return \SumanIon\TelegramBot\TelegramBotUser
     */
    public function getBotUser(Update $update)
    {
        $update = $update->message ??
                  $update->edited_message ??
                  $update->inline_query ??
                  $update->chosen_inline_result ??
                  $update->callback_query;
        $data   = $update->from ?? $update->chat;
        $user   = $this->bot->users()->where('chat_id', $data->id ?? $data->chat_id)->first();

        return $user ?? $this->bot->users()->create([
            'chat_id'    => $data->id ?? $data->chat_id,
            'first_name' => $data->first_name ?? '',
            'last_name'  => $data->last_name ?? '',
            'username'   => $data->username ?? ''
        ]);
    }
}