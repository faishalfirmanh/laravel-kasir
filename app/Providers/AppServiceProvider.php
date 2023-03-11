<?php

namespace App\Providers;

use App\Repository\Kategori\KategoriRepository;
use App\Repository\Kategori\KategoriRepositoryImplement;
use App\Service\Kategori\KategoriService;
use App\Service\Kategori\KategoriServiceImplement;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(KategoriRepository::class, KategoriRepositoryImplement::class);
        $this->app->bind(KategoriService::class, KategoriServiceImplement::class);
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
