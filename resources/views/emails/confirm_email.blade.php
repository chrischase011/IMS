<x-mail::message>
# Email Confirmation

Hi {{ $user }},

Please click the button below to confirm your email.

<x-mail::button :url="$url">
Confirm Email
</x-mail::button>

Thanks,<br>
Century Cardboard Box Factory & Printing Inc.
</x-mail::message>
