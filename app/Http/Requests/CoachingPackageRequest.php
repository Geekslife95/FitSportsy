<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CoachingPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'package_name' => 'required',
            'package_price' => 'required',
            'batch_size' => 'required',
            'package_discount' => 'required',
            'platform_fee' => 'required',
            'gateway_fee' => 'required',
            'description' => 'required',
            // 'start_time' => 'required',
            // 'end_time' => 'required',
            // 'session_days' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'session_days.array' => 'Select one or more session days'
        ];
    }
}
