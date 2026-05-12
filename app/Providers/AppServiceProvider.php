<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;
use App\Repositories\Interfaces\ArtikelRepositoryInterface;
use App\Repositories\Interfaces\HargaPasarRepositoryInterface;
use App\Repositories\Interfaces\KonsultasiRepositoryInterface;
use App\Repositories\KomoditasRepository;
use App\Repositories\ArtikelRepository;
use App\Repositories\HargaPasarRepository;
use App\Repositories\KonsultasiRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repository Pattern Bindings
        $this->app->bind(KomoditasRepositoryInterface::class, KomoditasRepository::class);
        $this->app->bind(ArtikelRepositoryInterface::class,   ArtikelRepository::class);
        $this->app->bind(HargaPasarRepositoryInterface::class, HargaPasarRepository::class);
        $this->app->bind(KonsultasiRepositoryInterface::class, KonsultasiRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
