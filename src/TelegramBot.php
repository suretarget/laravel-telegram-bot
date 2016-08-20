<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class TelegramBot extends Model
{
    /** @var array */
    protected $fillable = [
        'manager',
        'webhook_token',
        'offset'
    ];

    /**
     * Custom key for implicit model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'webhook_token';
    }

    /**
     * A bot may have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(TelegramBotUser::class);
    }

    /**
     * Create a new instance of bot manager.
     *
     * @return \SumanIon\TelegramBot\Manager
     */
    public function getManager()
    {
        return new $this->manager($this);
    }

    /**
     * Get bot where manager matches argument.
     *
     * @param  string $manager
     *
     * @return \SumanIon\TelegramBot\TelegramBot
     */
    public static function withManager(string $manager)
    {
        return static::where('manager', $manager)->firstOrFail();
    }
}