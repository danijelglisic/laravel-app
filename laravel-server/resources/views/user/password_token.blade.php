<x-mail::message>
{{ __('change_password.title') }}

{{ __('change_password.code') }}

# {{ $code }}

{{ __('change_password.thawnks') }}<br>
{{ config('app.name') }}<br>
{{__('change_password.duration', ['attribute' => App\Models\User::$TOKEN_DURATION])}}
</x-mail::message>