<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $instance = $this->route('instance');
        foreach($instance->services as $service) {
            if ($this->user()->cannot('view', $service)) {
                return false;
            }
        }
        return $this->user()->can('view-any Service')
               && $this->user()->can('view', $instance);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
