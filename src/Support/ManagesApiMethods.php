<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\TelegramBotUser;

trait ManagesApiMethods
{
    /**
     * Get information about the bot.
     *
     * @return stdClass|null
     */
    public function getMe()
    {
        return $this->sendRequest('getMe');
    }

    /**
     * Send an message to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $message
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendMessage(TelegramBotUser $user, $message, $options = [])
    {
        $options['chat_id']    = $user->chat_id;
        $options['text']       = $message;
        $options['parse_mode'] = $options['parse_mode'] ?? 'Markdown';
        $options['disable_web_page_preview'] = $options['disable_web_page_preview'] ?? true;

        return $this->sendRequest('sendMessage', $options);
    }

    /**
     * Send a file to Telegram.
     *
     * @param  TelegramBotUser $user
     * @param  string          $method
     * @param  string          $name
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendFile(TelegramBotUser $user, $method, $name, $path, $options)
    {
        $options['chat_id'] = $user->chat_id;

        $fields = [
            'multipart' => [
                [
                    'name' => $name,
                    'contents' => fopen($path, 'r')
                ]
            ]
        ];

        $this->sendPostRequest($method, $fields, $options);
    }

    /**
     * Send a photo to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendPhoto($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendPhoto', 'photo', $path, $options);
    }

    /**
     * Send an audio to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendAudio($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendAudio', 'audio', $path, $options);
    }

    /**
     * Send an document to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendDocument($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendDocument', 'document', $path, $options);
    }

    /**
     * Send a sticker to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendSticker($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendSticker', 'sticker', $path, $options);
    }

    /**
     * Send a video to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendVideo($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendVideo', 'video', $path, $options);
    }

    /**
     * Send voice record to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $path
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendVoice($user, $path, $options = [])
    {
        return $this->sendFile($user, 'sendVoice', 'voice', $path, $options);
    }

    /**
     * Send location to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $lat
     * @param  string          $long
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendLocation(TelegramBotUser $user, $lat, $long, $options = [])
    {
        $options['chat_id']   = $user->chat_id;
        $options['latitude']  = $lat;
        $options['longitude'] = $long;

        return $this->sendRequest('sendLocation', $options);
    }

    /**
     * Send a contact to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $phone
     * @param  string          $first
     * @param  string          $last
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendContact(TelegramBotUser $user, $phone, $first, $last, $options = [])
    {
        $options['chat_id']      = $user->chat_id;
        $options['phone_number'] = $phone;
        $options['first_name']   = $first;
        $options['last_name']    = $last;

        return $this->sendRequest('sendContact', $options);
    }

    /**
     * Send a chat action to the bot user.
     *
     * @param  TelegramBotUser $user
     * @param  string          $action
     * @param  array           $options
     *
     * @return stdClass|null
     */
    public function sendChatAction(TelegramBotUser $user, $action, $options = [])
    {
        $options['chat_id'] = $user->chat_id;
        $options['action']  = $action;

        return $this->sendRequest('sendChatAction', $options);
    }
}