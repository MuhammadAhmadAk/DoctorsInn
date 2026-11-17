DoctorsInn — New Contact Message

You received a new message through the website contact form.

Name:  {{ $senderName }}
Email: {{ $senderEmail }}
@if ($senderPhone)
Phone: {{ $senderPhone }}
@endif
@if ($topic)
Topic: {{ $topic }}
@endif

Message:
{{ $inquiry }}

---
Reply to this email to answer {{ $senderName }} directly.

DoctorsInn — Your companion to Success
{{ config('app.url') }}
