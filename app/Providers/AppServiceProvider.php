<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Ticket;
use App\Observers\HistoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('image', function ($expression) {
            return "<?php echo asset('image' . $expression); ?>";
        });
        Ticket::observe(HistoryObserver::class);
    }
}
