<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Illuminate\Console\Command;

class CheckStoryExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-story-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check story expiration and change is_story column in ads table to false if story is expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ads=Ad::where('is_story',true)->where('created_at','<=',now()->subDays(1))->get();
        foreach ($ads as $ad){
            $ad->update([
                'is_story'=>false
            ]);
           \Log::info('story with id '.$ad->id.' is expired');
        }
       \Log::info('story check done');

    }
}
