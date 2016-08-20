<?php

namespace SumanIon\TelegramBot\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SumanIon\TelegramBot\TelegramBot;

class WebhookController extends Controller
{
    public function store(Request $request, TelegramBot $bot)
    {
        $bot->getManager()->handleWebhook($request->getContent());
        return "";
    }
}