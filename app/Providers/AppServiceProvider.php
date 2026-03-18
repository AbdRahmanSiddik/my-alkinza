<?php

namespace App\Providers;

use App\Models\Toko;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo 'Rp. ' . number_format($expression, 0, ',', '.'); ?>";
        });

        View::composer('*', function ($view) {
            $shops = Toko::pluck('name', 'token_toko')->toArray();
            $view->with('shops', $shops);
        });

        \Carbon\Carbon::setLocale('id');
    }
}
