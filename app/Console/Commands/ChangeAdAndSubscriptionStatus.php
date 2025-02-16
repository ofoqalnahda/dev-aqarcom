<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeAdAndSubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changeStatusTask:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes the status of expired ads and subscriptions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        UserSubscription::where('end_date' , '<' , $now)->delete();

        $now->subDays(30);

        Ad::where('created_at' , '<' , $now)->update([
            'active' => 0
        ]);
    }
}
