<?php

namespace SumanIon\TelegramBot\Support;

trait Logger
{
    /**
     * Save logs.
     *
     * @var mixed
     */
    protected $logs = [];

    /**
     * Log a new message.
     *
     * @param  mixed  $message
     * @param  string $type
     *
     * @return void
     */
    public function log($message, string $type = 'log')
    {
        $this->logs[$type][] = $message;
    }

    /**
     * Get last log of a given type.
     *
     * @param  string $type
     *
     * @return mixed
     */
    public function getLog(string $type = 'log')
    {
        if (isset($this->logs[$type])) {
            return last($this->logs[$type]);
        }

        return null;
    }

    /**
     * Get all saved logs.
     *
     * @return array
     */
    public function getAllLogs()
    {
        return $this->logs;
    }
}