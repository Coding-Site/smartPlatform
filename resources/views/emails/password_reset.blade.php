@component('mail::message')
# Password Reset Request

You requested a password reset. Use the token below to reset your password:

**{{ $token }}**

If you did not request this, please ignore this email.

Thanks,
{{ config('app.name') }}
@endcomponent
