<?php

namespace SumanIon\TelegramBot\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateBotActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:action {name : The class name of the action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Telegram bot actions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $template = File::get(__DIR__ . '/../../templates/action.php');
        $template = str_replace('{{name}}', $name, $template);
        $dir = base_path('app/Bots/Actions');

        if (File::exists("{$dir}/{$name}.php")) {
            return $this->comment('A bot action with this name already exists.');
        }

        File::makeDirectory($dir, 0755, true, true);
        File::put("{$dir}/{$name}.php", $template);

        $this->info('A new bot action was created.');
    }
}
