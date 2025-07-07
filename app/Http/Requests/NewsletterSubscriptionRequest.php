<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;

class NewsletterSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'source' => 'sometimes|string|max:50',
            'preferences' => 'sometimes|array',
            'preferences.*' => 'string|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address is too long.',
            'email.regex' => 'Please enter a valid email address format.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $key = 'newsletter-subscribe:'.$this->ip();
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                $validator->errors()->add('email', "Too many subscription attempts. Please try again in {$seconds} seconds.");
            }

            if ($this->email) {
                $email = strtolower(trim($this->email));

                // Check for common disposable email domains
                $disposableDomains = [
                    '10minutemail.com', 'tempmail.org', 'guerrillamail.com',
                    'mailinator.com', 'throwaway.email', 'temp-mail.org',
                ];

                $emailDomain = substr(strrchr($email, '@'), 1);
                if (in_array($emailDomain, $disposableDomains)) {
                    $validator->errors()->add('email', 'Please use a permanent email address.');
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->email) {
            $this->merge([
                'email' => strtolower(trim($this->email)),
            ]);
        }
    }
}
