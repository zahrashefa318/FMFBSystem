<!-- resources/views/emails/test.blade.php -->

<x-mail::message>
# Hello!

This is a test email via Gmail SMTP from Laravel.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
