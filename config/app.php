<?php

return [

    'facebook_id' => env('FACEBOOK_CLIENT_ID'),
    'facebook_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'google_secret' => env('GOOGLE_CLIENT_SECRET'),

    'twitter_key' => env('TWITTER_KEY'),
    'twitter_secret' => env('TWITTER_SECRET'),
    'twitter_access_key' => env('TWITTER_ACCESS_TOKEN'),
    'twitter_access_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
     */

    'name' => 'RightToEducation',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
     */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
     */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
     */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
     */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
     */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
     */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
     */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
     */

    'log' => env('APP_LOG', 'daily'),

    'log_max_files' => env('LOG_MAX_FILE', 2),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        Collective\Html\HtmlServiceProvider::class,
        // LaravelProfane\ProfaneServiceProvider::class,
        /*
         * Application Service Providers...
         */
        Redlof\Engine\ServiceProviders\AppServiceProvider::class,
        Redlof\Engine\ServiceProviders\AuthServiceProvider::class,
        Redlof\Engine\ServiceProviders\RouteServiceProvider::class,
        Redlof\Core\ServiceProviders\AppServiceProvider::class,

        Redlof\Core\RedlofSDK\ServiceProviders\RedlofServiceProvider::class,

        HieuLe\Active\ActiveServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Aws\Laravel\AwsServiceProvider::class,
        Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
        Zizaco\Entrust\EntrustServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
        // Milon\Barcode\BarcodeServiceProvider::class,
        Shivella\Bitly\BitlyServiceProvider::class,
        Spatie\Backup\BackupServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        Barryvdh\Queue\AsyncServiceProvider::class,
        ConsoleTVs\Charts\ChartsServiceProvider::class,
        Dedicated\GoogleTranslate\GoogleTranslateProvider::class,
        // Jonasva\FacebookInsights\FacebookInsightsServiceProvider::class,
        // NotificationChannels\WebPush\WebPushServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
     */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Carbon' => 'Carbon\Carbon',

        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Active' => HieuLe\Active\Facades\Active::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'AWS' => Aws\Laravel\AwsFacade::class,
        'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
        'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,
        'Entrust' => Zizaco\Entrust\EntrustFacade::class,
        'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
        'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
        'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class,
        'Consumer' => Fusonic\OpenGraph\Consumer::class,
        'Analytics' => Spatie\Analytics\AnalyticsFacade::class,
        'Charts' => ConsoleTVs\Charts\Facades\Charts::class,
        'FacebookInsights' => Jonasva\FacebookInsights\Facades\FacebookInsights::class,
        'Uuid' => Webpatser\Uuid\Uuid::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Charts' => ConsoleTVs\Charts\Facades\Charts::class,
        'Translator' => Dedicated\GoogleTranslate\GoogleTranslateProvider::class,

        // Common helpers, don't add project specific helpers heres
        'AuthHelper' => 'Redlof\Core\Helpers\AuthHelper',
        'APIHelper' => 'Redlof\Core\Helpers\APIHelper',
        'AWSHelper' => 'Redlof\Core\Helpers\AWSHelper',
        'DateHelper' => 'Redlof\Core\Helpers\DateHelper',
        'UserHelper' => 'Redlof\Core\Helpers\UserHelper',
        'AppHelper' => 'Redlof\Core\Helpers\AppHelper',
        'MailHelper' => 'Redlof\Core\Helpers\MailHelper',
        'MsgHelper' => 'Redlof\Core\Helpers\MsgHelper',
        'RoleHelper' => 'Redlof\Core\Helpers\RoleHelper',
        'SocialHelper' => 'Redlof\Core\Helpers\SocialHelper',
        'ImageHelper' => 'Redlof\Core\Helpers\ImageHelper',
        'ActitvityHelper' => 'Redlof\Core\Helpers\ActitvityHelper',
        'AppDataCache' => 'Redlof\Core\Helpers\AppDataCache',

        // Exception Classes
        'EntryCreationFailed' => 'Redlof\Core\Exceptions\EntryCreationFailed',
        'EntityNotFoundException' => 'Redlof\Core\Exceptions\EntityNotFoundException',
        'ActionFailedException' => 'Redlof\Core\Exceptions\ActionFailedException',

    ],

];
