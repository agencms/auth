<?php

namespace Silvanite\AgencmsAuth\Handlers;

use Silvanite\Agencms\Route;
use Silvanite\Agencms\Field;
use Silvanite\Agencms\Group;
use Silvanite\Agencms\Option;
use Silvanite\Brandenburg\Policy;
use Silvanite\Agencms\Relationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Silvanite\Agencms\Facades\Agencms;

class AgencmsHandler
{
    /**
     * Register all routes and models for the Admin GUI (AUI)
     *
     * @return void
     */
    public static function registerAdmin()
    {
        if (!Gate::allows('admin_access')) return;

        self::registerUsersAdmin();
        self::registerRolesAdmin();
    }

    /**
     * Register the Agencms endpoints for User administration
     *
     * @return void
     */
    private static function registerUsersAdmin()
    {
        if (!Gate::allows('users_read')) return;

        Agencms::registerRoute(
            Route::init('users', ['Users' => 'Manage Users'], '/agencms-auth/users')
                ->icon('person')
                ->addGroup(
                    Group::large('Details')->addField(
                        Field::number('id', 'Id')->readonly()->list(),
                        Field::string('name', 'Name')->medium()->required()->list(),
                        Field::string('email', 'Email')->medium()->required()->list(),
                        Field::related('roleids', 'Roles')->model(
                            Relationship::make('roles')
                        )
                    ),
                    Group::small('Extra')->addField(
                        Field::boolean('active', 'Active')->list(),
                        Field::image('avatar', 'Profile Picture')->ratio(600, 600, $resize = true)
                    )   
                )
        );
    }

    /**
     * Register the Agencms endpoints for Role/Permission administration
     *
     * @return void
     */
    private static function registerRolesAdmin()
    {
        if (!Gate::allows('roles_read')) return;

        Agencms::registerRoute(
            Route::init('roles', ['Users' => 'Manage Roles'], '/agencms-auth/roles')
                ->icon('supervisor_account')
                ->addGroup(Group::full('Details')->addField(
                    Field::number('id', 'Id')->readonly()->list(),
                    Field::string('name', 'Name')->medium()->required()->list(),
                    Field::string('slug', 'Slug')->medium()->required()->list(),
                    Field::select('permissions', 'Permissions')->addOptions(
                        Policy::all()
                    )->medium()->multiple()->dropdown()
                ))
        );
    }
}
