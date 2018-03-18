<?php

namespace Agencms\Auth\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Request::isMethod('post')) {
            return Gate::allows('roles_create');
        }

        if (Request::isMethod('put')) {
            return Gate::allows('roles_update');
        }

        if (Request::isMethod('destory')) {
            return Gate::allows('roles_delete');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('destroy')) {
            return [];
        }

        return [
            'name' => 'required|string',
            'slug' => 'required|alpha_dash',
            'permissions' => 'nullable',
        ];
    }
}
