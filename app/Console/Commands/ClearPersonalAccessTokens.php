<?php

namespace App\Console\Commands;

use App\Models\PersonalAccessToken;
use Illuminate\Console\Command;

class ClearPersonalAccessTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-personal-access-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Personal Access Tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line(PersonalAccessToken::where('created_at', '<', now()->subDays(30))->delete());
        return Command::SUCCESS;
    }
}
