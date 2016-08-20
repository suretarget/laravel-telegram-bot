<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Update;
use Illuminate\Support\Facades\Cache;
use SumanIon\TelegramBot\TelegramBotUser;
use SumanIon\TelegramBot\Exceptions\SkipAction;

trait ManagesActionTriggers
{
    /**
     * The name of the trigger.
     *
     * @var string
     */
    protected $triggerName;

    /**
     * Additional data used by the trigger.
     *
     * @var mixed
     */
    protected $triggerData;

    /**
     * Create a unique cache key for every chat user.
     *
     * @param  string $name
     *
     * @return string
     */
    public function getCacheKey(string $chat_id):string
    {
        return 'telegram|' . get_class($this) . '|' . $chat_id;
    }

    /**
     * Save information about the trigger.
     *
     * @param  string $name
     * @param  mixed  $data
     *
     * @return void
     */
    public function registerTrigger(string $name, $data = null)
    {
        $this->triggerName = $name;
        $this->triggerData = $data;
    }

    /**
     * Cache the trigger when all actions are executed.
     *
     * @param  TelegramBotUser $user
     *
     * @return void
     */
    public function saveTrigger(TelegramBotUser $user)
    {
        if (!$this->triggerName) {
            return Cache::forget($this->getCacheKey($user->chat_id));
        }

        Cache::put(
            $this->getCacheKey($user->chat_id),
            json_encode([
                $this->triggerName,
                $this->triggerData
            ]),
            60
        );
    }

    /**
     * Get information about the cached trigger.
     *
     * @param  TelegramBotUser $user
     *
     * @return array
     */
    public function getTriggerInfo(TelegramBotUser $user)
    {
        $info = Cache::get($this->getCacheKey($user->chat_id), '');
        $info = json_decode($info, true);

        if (!$info) {
            return [null, null];
        }

        return $info;
    }

    /**
     * Get the name of the cached trigger.
     *
     * @param  TelegramBotUser $user
     *
     * @return string|null
     */
    public function getTriggerName(TelegramBotUser $user)
    {
        return $this->getTriggerInfo($user)[0];
    }

    /**
     * Get the data of the cached trigger.
     *
     * @param  TelegramBotUser $user
     *
     * @return mixed
     */
    public function getTriggerData(TelegramBotUser $user)
    {
        return $this->getTriggerInfo($user)[1];
    }

    /**
     * Keep current trigger for the next request.
     *
     * @param  TelegramBotUser $user
     *
     * @return void
     */
    public function keepTrigger(TelegramBotUser $user)
    {
        if ($this->triggerName) {
            return;
        }

        $info = $this->getTriggerInfo($user);

        $this->triggerName = $info[0];
        $this->triggerData = $info[1];
    }

    /**
     * Skip current action if trigger doesn't match.
     *
     * @param  TelegramBotUser $user
     * @param  string          $trigger
     *
     * @return void
     */
    public function runsAfter(TelegramBotUser $user, string $trigger)
    {
        if ($trigger !== $this->getTriggerName($user)) {
            throw new SkipAction;
        }
    }
}