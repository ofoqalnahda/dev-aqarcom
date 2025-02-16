<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//         Telescope::night();

        $this->hideSensitiveRequestDetails();
        $queries = [];
        $i = 1;
        Telescope::filter(function (IncomingEntry $entry) use (&$queries, &$i) {
            if ($this->app->environment('local')) {
                if ($entry->type === 'query') {
                    // Generate a unique key for the query and bindings
                    $queryKey = $entry->content['sql'] . serialize($entry->content['bindings']);
                    $queryKey = $entry->content['hash'];

                    if (isset($queries[$queryKey])) {
                        $queries[$queryKey]['count']++;
                        // If the query has been executed before, mark it as a duplicate
                        $entry->content['duplicated'] = true;

                        $file = explode('/', $entry->content['file']);
                        $file_count = count($file);
                        if($file_count < 2)
                    {
                        $file = explode('\\', $entry->content['file']);
                        $file_count = count($file);
                    }

                        $file_path = $file[$file_count - 2] . '/' . $file[$file_count - 1];


                        $line = $entry->content['line'];
                        $entry->content['sql'] = "{$queries[$queryKey]['id']}- {$file_path}:{$line} {$entry->content['sql']}";

                    } else {
                        $queries[$queryKey] = [
                            'count' => 1,
                            'id' => $i,
                        ];
                        $entry->content['duplicate'] = false;
                        $entry->content['sql'] = "{$i}- {$entry->content['sql']}";

                    }
                    $i++;
                }
                return true;
            }

            return $entry->isReportableException() ||
            $entry->isFailedRequest() ||
            $entry->isFailedJob() ||
            $entry->isScheduledTask() ||
            $entry->hasMonitoredTag();
        });
//        dd($queries);
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
}
