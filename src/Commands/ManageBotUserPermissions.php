<?php

namespace SumanIon\TelegramBot\Commands;

use Illuminate\Console\Command;
use SumanIon\TelegramBot\TelegramBotPermission;

class ManageBotUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:permission {name} {label?} {--remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage bot user permissions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        if ($this->option('remove')) {
            TelegramBotPermission::where('name', $name)->delete();
            return $this->info("The permission with name '{$name}' was successfully deleted.");
        }

        if (TelegramBotPermission::where('name', $name)->first()) {
            return $this->comment('A permission with this name already exists.');
        }

        TelegramBotPermission::create([
            'name' => $name,
            'label' => $this->argument('label')
        ]);

        $this->info("A new permission with name '{$name}' was successfully created.");
    }
}
