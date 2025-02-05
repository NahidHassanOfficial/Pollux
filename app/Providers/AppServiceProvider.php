<?php
namespace App\Providers;

use App\Models\Poll;
use App\Models\User;
use App\Observers\PollObserver;
use App\Observers\RegistrationObserver;
use Illuminate\Support\ServiceProvider;

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
        User::observe(RegistrationObserver::class);
        Poll::observe(PollObserver::class);
    }
}
