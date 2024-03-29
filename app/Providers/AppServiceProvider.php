<?php

namespace App\Providers;

use App\Services\WhatsApp\WhatsAppService;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('WhatsAppService', function () {
            $baseUrl = config('whatsapp.base_url');
            $port = config('whatsapp.port');
            $secretKey = config('whatsapp.secret_key');
            $session = config('whatsapp.session');

            $client = (new PendingRequest)
                ->baseUrl("{$baseUrl}:{$port}/api/{$session}/")
                ->withToken($secretKey)
                ->withHeaders(['Content-Type' => 'application/json']);

            return new WhatsAppService($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'primary' => Color::Fuchsia,
        ]);

        // Fix https (ngrok)
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $this->app['request']->server->set('HTTPS', true);
        }

        Request::macro('isMobile', function () {
            /** @var Request $this */
            return preg_match('/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i', $this->header('User-Agent')) ? true : false;
        });

        RateLimiter::for('whatsapp', fn() => Limit::perMinute(20));
    }
}
