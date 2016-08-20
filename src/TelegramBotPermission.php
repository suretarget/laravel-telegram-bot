<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class TelegramBotPermission extends Model
{
    /** @var array */
    protected $fillable = [
        'name',
        'label'
    ];
}