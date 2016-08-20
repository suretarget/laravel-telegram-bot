<?php

namespace SumanIon\TelegramBot\Commands;

use Illuminate\Console\Command;
use SumanIon\TelegramBot\TelegramBot;

class DeleteBots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:delete {manager : FQCN}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Telegram bots from the database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $manager = $this->argument('manager');
        $bot = TelegramBot::where('manager', $manager)->first();

        if (!$bot) {
            return $this->comment("A bot with manager '{$manager}' was not found.");
        }

        $bot->delete();
        $this->info("A bot with manager '{$manager}' was successfully deleted.");
    }
}
