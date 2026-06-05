<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('customer') ? 'update customers' : 'create customers');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:regular,vip,corporate,lead'],
            'status' => ['required', 'in:active,inactive,prospect'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
