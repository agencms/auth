<?php

namespace Silvanite\AgencmsAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;
use Route;
use Silvanite\Agencms\Facades\ConfigFacade as Agencms;

use Silvanite\Brandenburg\Policy;
use Silvanite\Brandenburg\Permission;

use Silvanite\AgencmsAuth\Middleware\AgencmsConfig;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;

class AgencmsAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router, Kernel $kernel)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->registerApiRoutes();
        $this->registerPolicies();

        $this->registerAgencms($router);
    }

    /**
     * Register router middleware as plugin for Agencms. This will include all
     * user related admin screen and endpoints in the CMS.
     *
     * @param Router $router
     * @return void
     */
    private function registerAgencms(Router $router)
    {
        $router->aliasMiddleware('agencms.auth', AgencmsConfig::class);
        Agencms::registerPlugin('agencms.auth');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPermissions();
    }

    /**
     * Load Api Routes into the application
     *
     * @return void
     */
    private function registerApiRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    /**
     * Register the Policies module
     *
     * @param string $IoC name of the container
     * @return Silvanite\Brandenburg\Policy
     */
    private function registerPolicies($container = "BrandenburgPolicy")
    {
        $this->app->bind($container, function(){
            return new Policy;
        });
    }

    /**
     * Register default package related permissions
     *
     * @return void
     */
    private function registerPermissions()
    {
        collect([
            'users_read', 
            'users_update', 
            'users_create', 
            'users_delete', 
            'roles_read', 
            'roles_update', 
            'roles_create', 
            'roles_delete', 
            'permissions_read', 
            'permissions_update', 
            'permissions_create', 
            'permissions_delete', 
        ])->map(function($permission) {
            Gate::define($permission, function ($user) use ($permission) {
                if ($this->nobodyHasAccess($permission)) return true;

                return $user->hasRoleWithPermission($permission);
            });
        });
    }

    /**
     * If nobody has this permission, grant access to everyone
     * This avoids you from being locked out of your application
     *
     * @param string $permission
     * @return boolean
     */
    private function nobodyHasAccess($permission)
    {
        if (!$requestedPermission = Permission::find($permission)) return true;

        return !$requestedPermission->hasUsers();
    }
}
