<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Employee;
use App\Repositories\DepartmentRepositoryEloquent;
use App\Repositories\EmployeeRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: 'App\Repositories\DepartmentRepositoryInterface', concrete: 'App\Repositories\DepartmentRepositoryEloquent');

        $this->app->bind(abstract: 'App\Repositories\DepartmentRepositoryInterface', concrete: function(){
            return new DepartmentRepositoryEloquent(new Department());
        });

        $this->app->bind(abstract: 'App\Repositories\EmployeeRepositoryInterface', concrete: 'App\Repositories\EmployeeRepositoryEloquent');

        $this->app->bind(abstract: 'App\Repositories\EmployeeRepositoryInterface', concrete: function(){
            return new EmployeeRepositoryEloquent(new Employee());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
