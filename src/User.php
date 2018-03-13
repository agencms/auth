<?php

namespace Agencms\Auth;

use App\User as BaseUser;
use Illuminate\Notifications\Notifiable;
use Silvanite\Brandenburg\Traits\HasRoles;

class User extends BaseUser
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes which should be extended to the model
     *
     * @var array
     */
    protected $appends = [
        'roleids'
    ];

    protected function getArrayableAppends()
    {
        $this->appends = array_unique(
            array_merge($this->appends, ['roleids'])
        );

        return parent::getArrayableAppends();
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        $this->fillable = array_unique(
            array_merge($this->fillable, ['api_token'])
        );

        return parent::getFillable();
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        $this->hidden = array_unique(
            array_merge($this->hidden, ['api_token'])
        );

        return parent::getHidden();
    }

    /**
     * Generate an array of Role IDs for this model
     *
     * @return array
     */
    public function getRoleidsAttribute()
    {
        return $this->roles()->pluck('id');
    }
}
