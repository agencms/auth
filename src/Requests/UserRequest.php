<?php

namespace Agencms\Auth\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Request::isMethod('post')) {
            return Gate::allows('users_create');
        }

        if (Request::isMethod('put')) {
            return Gate::allows('users_update');
        }

        if (Request::isMethod('destory')) {
            return Gate::allows('users_delete');
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
            'email' => 'required|email',
            'avatar' => 'nullable|string',
            'active' => 'nullable|boolean',
            'roles' => 'nullable|array',
            'tenant' => 'required|string',
            'site' => 'required|string',
        ];
    }
}
