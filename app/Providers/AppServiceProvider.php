<?php

namespace App\Providers;

use App\Repository\Kategori\KategoriRepository;
use App\Repository\Kategori\KategoriRepositoryImplement;
use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\KeranjangKasir\KeranjangKasirRepositoryImplement;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\NewStruck\NewStruckRepositoryImpelemnt;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\ProductRepositoryImplement;
use App\Repository\ProductJual\ProductJualRepository;
use App\Repository\ProductJual\ProductJualRepositoryImplement;
use App\Repository\Role\RoleRepository;
use App\Repository\Role\RoleRepositoryImplement;
use App\Repository\Users\UserRepository;
use App\Repository\Users\UserRepositoryImplement;
use App\Service\Kategori\KategoriService;
use App\Service\Kategori\KategoriServiceImplement;
use App\Service\KeranjangKasir\KeranjangKasirService;
use App\Service\KeranjangKasir\KeranjangKasirServiceImplement;
use App\Service\NewStruck\NewStruckService;
use App\Service\NewStruck\NewStruckServiceImplement;
use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceImplement;
use App\Service\ProductJual\ProductJualService;
use App\Service\ProductJual\ProductJualServiceImplement;
use App\Service\Role\RoleService;
use App\Service\Role\RoleServiceImplement;
use App\Service\Users\UserService;
use App\Service\Users\UserServiceImplement;
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
        $this->app->bind(ProductJualRepository::class, ProductJualRepositoryImplement::class);
        $this->app->bind(ProductJualService::class,ProductJualServiceImplement::class);
        //
        $this->app->bind(RoleRepository::class, RoleRepositoryImplement::class);
        $this->app->bind(RoleService::class, RoleServiceImplement::class);
        $this->app->bind(UserRepository::class,UserRepositoryImplement::class);
        $this->app->bind(UserService::class, UserServiceImplement::class);

        //struck
        $this->app->bind(NewStruckRepository::class, NewStruckRepositoryImpelemnt::class);
        $this->app->bind(NewStruckService::class, NewStruckServiceImplement::class);
        //keranjangToStruck
        $this->app->bind(KeranjangKasirService::class, KeranjangKasirServiceImplement::class);
        $this->app->bind(KeranjangKasirRepository::class, KeranjangKasirRepositoryImplement::class);
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
