<?php

namespace App\Providers;

use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Exam\ExamBankRepository;
use App\Repositories\Exam\ExamBankRepositoryInterface;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\ExamRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(ExamRepositoryInterface::class, ExamRepository::class);
        $this->app->bind(ExamBankRepositoryInterface::class, ExamBankRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
