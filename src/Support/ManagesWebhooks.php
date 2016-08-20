<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;

trait ManagesWebhooks
{
    /**
     * Get current webhook url.
     *
     * @return string
     */
    public function getWebhookUrl():string
    {
        return url("/api/telegram/{$this->bot->webhook_token}");
    }

    /**
     * Set a new webhook.
     *
     * @return stdClass
     */
    public function setWebhook()
    {
        return $this->sendRequest('setWebhook', [
            'url' => $this->getWebhookUrl()
        ]);
    }

    /**
     * Remove a webhook.
     *
     * @return stdClass
     */
    public function removeWebhook()
    {
        return $this->sendRequest('setWebhook');
    }

    /**
     * Handle incomming webhook.
     *
     * @param  string $update
     *
     * @return void
     */
    public function handleWebhook(string $update)
    {
        $this->handleUpdate(new Update($update));
    }
}