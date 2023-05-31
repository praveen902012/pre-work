<?php
namespace Redlof\Core\RedlofSDK\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class RedlofServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {

        // $this->logWorkflow();
    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->register("Redlof\Core\RedlofSDK\ServiceProviders\RedlofMailServiceProvider");
        $this->app->register("Redlof\Core\RedlofSDK\ServiceProviders\RedlofRouteServiceProvider");
    }

    private function logWorkflow()
    {

        // Checking if Query logging is required

        // Check if query logging settings file is generated
        if (!\Storage::disk('local')->exists('redlof/redlof-db-querylogger-settings')) {

            $request_data = [
                'workflow_enabled' => false,
                'file_name' => null,
            ];

            $settings_content = json_encode($request_data);

            \Storage::disk('local')->put('redlof/redlof-db-querylogger-settings', $settings_content);
        }

// Check if query logging is set & still active

        $setting_file_content = \Storage::disk('local')->get('redlof/redlof-db-querylogger-settings');

        $parsed_content = json_decode($setting_file_content);

        if (isset($parsed_content->workflow_enabled) && !$parsed_content->workflow_enabled) {

            return;
        }

        $file_path = 'redlof/' . $parsed_content->file_name;

        \DB::listen(function ($query) use ($file_path) {

            $data = [
                'query' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ];

            $content_string = json_encode($data);

            // Write to a specific JSON file in the storage
            \Storage::disk('local')->append($file_path, $content_string);
        });

    }

}
