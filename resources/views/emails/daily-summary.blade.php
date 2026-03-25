@component('mail::message')
# Hello, {{ $user->name }}

You have **{{ $notifications->count() }}** unread notification(s).

@component('mail::button', ['url' => url('/contact')])
View All Notifications
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent