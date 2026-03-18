<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'display_starts_at' => ['required', 'date'],
            'display_ends_at' => ['required', 'date', 'after:display_starts_at'],
            'links' => ['nullable', 'array'],
            'links.*' => ['url', 'max:255'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['string', 'max:255'],
            'steps.*.completed' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
