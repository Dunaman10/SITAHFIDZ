<?php

namespace App\Providers;

use App\Http\Responses\CustomLogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Http\Responses\Auth\LogoutResponse;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
  }
}
