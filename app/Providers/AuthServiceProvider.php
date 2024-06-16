<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\IncidentePolicy;
use App\Models\Incidente;

use App\Policies\UserPolicy;
use App\Models\User;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Incidente::class => IncidentePolicy::class,
        User::class => UserPolicy::class,
    ];
    

    public function boot()
    {
        $this->registerPolicies();
    }
}