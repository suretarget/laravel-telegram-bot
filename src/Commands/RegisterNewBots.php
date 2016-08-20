<?php

namespace SumanIon\TelegramBot\Commands;

use Illuminate\Console\Command;
use SumanIon\TelegramBot\TelegramBot;

class RegisterNewBots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:bot {manager : FQCN} {webhook_token? : A random string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new Telegram bots';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $manager = $this->argument('manager');

        if (TelegramBot::where('manager', $manager)->first()) {

            return $this->comment('A bot with this manager already exists.');
        }

        $bot = TelegramBot::create([
            'manager' => $manager,
            'webhook_token' => $this->argument('webhook_token') ?? str_random(12)
        ]);

        $this->info("A bot with manager '{$manager}' was successfully created.");
    }
}
