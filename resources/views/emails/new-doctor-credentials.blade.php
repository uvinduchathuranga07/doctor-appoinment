@component('mail::message')
# Welcome to Our Platform!

Dear Doctor,

Your account has been successfully created. You can now log in using the following credentials:

**Email:** {{ $email }}
**Password:** {{ $password }}

Please change your password after your first login for security reasons.

@component('mail::button', ['url' => url('/login')])
Login Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent