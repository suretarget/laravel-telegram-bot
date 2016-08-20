<?php

namespace SumanIon\TelegramBot\Commands;

use Illuminate\Console\Command;
use SumanIon\TelegramBot\TelegramBot;

class ManageWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook {manager : FQCN} {--remove : Remove webhook}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set or Remove Telegram bot webhooks';

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

        $manager = $bot->getManager();

        if ($this->option('remove')) {
            $response = $manager->removeWebhook();
        } else {
            $response = $manager->setWebhook();
        }

        if (!$response) {
            return $this->comment($manager->getLastApiError()->description);
        }

        $this->info($response->description);
    }
}
