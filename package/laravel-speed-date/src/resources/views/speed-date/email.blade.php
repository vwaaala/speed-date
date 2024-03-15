<x-mail::message>
# Introduction
You have a new contact message from {{ $subject }}.

{{ $message }}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
