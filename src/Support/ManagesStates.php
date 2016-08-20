<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;
use Illuminate\Support\Facades\Cache;
use SumanIon\TelegramBot\TelegramBotUser;
use SumanIon\TelegramBot\Exceptions\SkipAction;

trait ManagesStates
{
    /**
     * The name of the state.
     *
     * @var string
     */
    protected $stateName;

    /**
     * Additional data used by the state.
     *
     * @var mixed
     */
    protected $stateData;

    /**
     * Create a unique cache key for every chat user.
     *
     * @param  string $name
     *
     * @return string
     */
    public function getStateCacheKey(string $chat_id):string
    {
        return 'telegram|' . get_class($this) . '|states|' . $chat_id;
    }

    /**
     * Save information about the state.
     *
     * @param  string $name
     * @param  mixed  $data
     *
     * @return void
     */
    public function registerState(string $name, $data = null)
    {
        $this->stateName = $name;
        $this->stateData = $data;
    }

    /**
     * Alias for 'registerState' method.
     *
     * @param string $name
     * @param mixed  $data
     */
    public function setState(string $name, $data = null)
    {
        return $this->registerState($name, $data);
    }

    /**
     * Cache the state when all actions are executed.
     *
     * @param  TelegramBotUser $user
     *
     * @return void
     */
    public function saveState(TelegramBotUser $user)
    {
        if (!$this->stateName) {
            return Cache::forget($this->getStateCacheKey($user->chat_id));
        }

        Cache::put(
            $this->getStateCacheKey($user->chat_id),
            json_encode([
                $this->stateName,
                $this->stateData
            ]),
            60
        );
    }

    /**
     * Get information about the cached state.
     *
     * @param  TelegramBotUser $user
     *
     * @return array
     */
    public function getStateInfo(TelegramBotUser $user)
    {
        $info = Cache::get($this->getStateCacheKey($user->chat_id), '');
        $info = json_decode($info, true);

        if (!$info) {
            return [null, null];
        }

        return $info;
    }

    /**
     * Get the name of the cached state.
     *
     * @param  TelegramBotUser $user
     *
     * @return string|null
     */
    public function getStateName(TelegramBotUser $user)
    {
        return $this->getStateInfo($user)[0];
    }

    /**
     * Get the data of the cached state.
     *
     * @param  TelegramBotUser $user
     *
     * @return mixed
     */
    public function getStateData(TelegramBotUser $user)
    {
        return $this->getStateInfo($user)[1];
    }

    /**
     * Keep current state for the next request.
     *
     * @param  TelegramBotUser $user
     *
     * @return void
     */
    public function keepState(TelegramBotUser $user)
    {
        if ($this->stateName) {
            return;
        }

        $info = $this->getStateInfo($user);

        $this->stateName = $info[0];
        $this->stateData = $info[1];
    }

    /**
     * Skip current action if state doesn't match.
     *
     * @param  TelegramBotUser $user
     * @param  array|string    $state
     *
     * @return void
     */
    public function respondsToState(TelegramBotUser $user, $state)
    {
        $states = (array)$state;

        foreach ($states as $state) {
            if ($state === $this->getStateName($user)) {
                return;
            }
        }

        throw new SkipAction;
    }

    /**
     * Alias for 'respondsToState' method.
     *
     * @param  TelegramBotUser $user
     * @param  array|string    $state
     *
     * @return void
     */
    public function respondsToStates(TelegramBotUser $user, array $states)
    {
        return $this->respondsToState($user, $states);
    }
}