<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Exceptions\MethodNotFound;

trait ProxiesManagerMethods
{
    /**
     * List of methods to be proxified,
     * user instance is prepended to the arguments list.
     *
     * @var array
     */
    protected $proxifiedUserMethods = [
        'sendMessage',
        'sendPhoto',
        'sendAudio',
        'sendDocument',
        'sendSticker',
        'sendVideo',
        'sendVoice',
        'sendLocation',
        'sendContact',
        'sendChatAction',

        'getStateInfo',
        'getStateName',
        'getStateData',
        'keepState',
        'respondsToState',
        'respondsToStates'
    ];

    /**
     * List of methods to be proxified.
     *
     * @var array
     */
    protected $proxifiedMethods = [
        'registerState',
        'setState'
    ];

    /**
     * Proxy methods from the bot manager.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, $this->proxifiedUserMethods)) {

            return call_user_func_array(
                [$this->manager, $name],
                array_merge([$this->user], $arguments)
            );
        }

        if (in_array($name, $this->proxifiedMethods)) {
            return call_user_func_array(
                [$this->manager, $name],
                $arguments
            );
        }

        throw new MethodNotFound("Method '{$name}' was not found.");
    }
}