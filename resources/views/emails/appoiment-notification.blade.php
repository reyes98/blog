@component('mail::message')
# Appoiment Notification

<p>Name: {{ $data['name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Phone: {{ $data['phone'] }}</p>
<p>Message: {{ $data['message'] }}</p>
<p>Appoiment Date: {{ $data['start_time'] }}</p>
<p>Status: {{ $data['status'] }}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent