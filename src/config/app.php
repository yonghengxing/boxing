<?php

return [
    
//产品分类：波形，标准，测试文档，设计文档
    'comp_status' => [
        '1000' => '不可入库',
        '1001' => '可入库',
        '2000' => '暂无新版本',
        '2001' => '有新版本待测试',
        '10000' => '暂无新事件',
        '10001' => '有新事件待审核',
    ],
    
    'import_status' => [
        '1001' => '可入库',
        '1000' => '不可入库',
    ],
    
    'comp_type' => [
        '100' => '波形',
        '200' => '标准',
        '300' => '测试文档',
        '400' => '设计文档',
    ],
    
    //人员分类: 开发方、使用方、测试方、机关
    'user_role' => [
        '1000' => '开发方',
        '2000' => '测试方',
        '3000' => '机关',
        '4000' => '集成方',
        '5000' => '使用方',
    ],
    
    'appr_type' => [
        '11000' => '开发方入受控库',
        '12000' => '测试方出受控库',
        '13000' => '测试方入产品库',
    ],
    
    'appr_pass' => [
        '0' => '不通过',
        '1' => '通过',
    ],
    
    'action_type' => [
        '10000' => '开发方入库',
        '20000' => '测试方出库',
        '30000' => '测试方入库',
    ],
    
    'dev_status' => [
        '1100' => '待入库审核',
        '1101' => '已入受控库',
        '1102' => '测试申请成功',
        '1110' => '验证不通过',
        '1111' => '入受控库被拒',
        '1200' => '正在测试',
        '1201' => '测试通过',
        '1210' => '测试不通过',
        '1301' => '已入产品库',
    ],
    
    'appr_status' => [
        '11000' => '正在进行',
        '11001' => '审批通过',
        '11100' => '审批被拒',
        '11101' => '审核不能推进',
        '21000' => '正在进行',
        '21001' => '审批通过',
        '21100' => '审批被拒',
        '21101' => '审核不能推进',
        '31000' => '正在进行',
        '31001' => '审批通过',
        '31100' => '审批被拒',
        '31101' => '审核不能推进',
    ],
    
    'test_status' => [
        '2100' => '测试待领取',
        '2101' => '待出库审核',
        '2102' => '待出受控库',
        '2103' => '待测试完成',
        '2104' => '待入库审核',
        '2105' => '已入产品库',
        '2110' => '测试不通过',
        '2111' => '入产品库被拒',
    ],
    
    'test_show' => [
        '2100' => '申请被拒绝',
        '2101' => '待出库审核',
        '2102' => '待出受控库',
        '2103' => '待测试完成',
        '2104' => '待入库审核',
        '2105' => '已入产品库',
        '2110' => '测试不通过',
        '2111' => '入产品库被拒',
    ],
    
    'test_assigned' => [
        '0' => '测试待领取',
        '1' => '已领取',
    ],
    
    'test_assigned2' => [
        '2100' => '测试待领取',
        '2101' => '已领取待审核',
        '2102' => '已领取已审核',
        '2103' => '已领取已审核',
        '2104' => '已领取已审核',
        '2105' => '已领取已审核',
        '2110' => '已领取已审核',
        '2111' => '已领取已审核',
    ],
    
    'issue_status' => [
        '0' => '待解决',
        '1' => '已解决',
    ],
    
    'device_status' => [
        '900' => '推送失败',
        '901' => '推送成功未授权',
        '902' => '推送成功已授权',
    ],
    
    'event_status' => [
        '1100' => '待入库审核',
        '1101' => '已入受控库',
        '1102' => '已申请测试',
        '1110' => '验证不通过',
        '1111' => '入受控库被拒',
        '1200' => '正在测试',
        '1201' => '测试通过',
        '1210' => '测试不通过',
        '1301' => '已入产品库',
        '11000' => '正在进行',
        '11001' => '审批通过',
        '11100' => '审批被拒',
        '11101' => '审核不能推进',
        '21000' => '正在进行',
        '21001' => '审批通过',
        '21101' => '审核不能推进',
        '21100' => '审批被拒',
        '31000' => '正在进行',
        '31001' => '审批通过',
        '31100' => '审批被拒',
        '31101' => '审核不能推进',
        '2100' => '测试待领取',
        '2101' => '待出库审核',
        '2102' => '待出受控库',
        '2103' => '待测试完成',
        '2104' => '待入库审核',
        '2105' => '已入产品库',
        '2110' => '测试不通过',
        '2111' => '入产品库被拒',
    ],
    
    'auth_enable' => [
        '0' => '不授权',
        '1' => '授权',
    ],
    
    'admin_mode' => env('ADMIN_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
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

    'asset_url' => env('ASSET_URL', null),

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

    'timezone' => 'Asia/Shanghai',

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
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

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

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Chumper\Zipper\ZipperServiceProvider::class,

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
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
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
        'Zipper' => Chumper\Zipper\Zipper::class,

    ],

];
