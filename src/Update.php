<?php

namespace SumanIon\TelegramBot;

use stdClass;

class Update extends stdClass
{
    /**
     * Parse update data.
     *
     * @param mixed $update
     */
    public function __construct($update)
    {
        $this->fromString($update);
        $this->fromObject($update);
        $this->fromArray($update);
    }

    /**
     * Parse update from string.
     *
     * @param  mixed $update
     *
     * @return void
     */
    public function fromString($update)
    {
        if (is_string($update)) {
            $this->fromObject(json_decode($update));
        }
    }

    /**
     * Parse update from stdClass.
     *
     * @param  mixed $update
     *
     * @return void
     */
    public function fromObject($update)
    {
        if ($update instanceof stdClass) {
            foreach ($update as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Parse update from array.
     *
     * @param  mixed $update
     *
     * @return void
     */
    public function fromArray($update)
    {
        if (is_array($update)) {
            foreach ($update as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Access methods like properties.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->{$key}();
    }

    /**
     * Get text from the update.
     *
     * @return mixed
     */
    public function text()
    {
        return $this->message->text ?? null;
    }

    /**
     * Parse command from the update.
     *
     * @return array
     */
    public function parseCommand():array
    {
        $text = $this->message->text ?? '';

        if (preg_match('/^(\:|\/)(\S+)(.*?)?$/', $text, $matches)) {
            return [
                mb_strtolower($matches[2]),
                trim($matches[3])
            ];
        }

        return [null, null];
    }

    /**
     * Get the command name from the update.
     *
     * @return string|null
     */
    public function command()
    {
        return $this->parseCommand()[0];
    }

    /**
     * Get command value from the update.
     *
     * @return string|null
     */
    public function commandValue()
    {
        return $this->parseCommand()[1];
    }
}