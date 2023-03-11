<?php

namespace App\Providers;

use App\Repository\Kategori\KategoriRepository;
use App\Repository\Kategori\KategoriRepositoryImplement;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\ProductRepositoryImplement;
use App\Service\Kategori\KategoriService;
use App\Service\Kategori\KategoriServiceImplement;
use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceImplement;
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

        $this->app->bind(ProductRepository::class, ProductRepositoryImplement::class);
        $this->app->bind(ProductService::class, ProductServiceImplement::class);
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
