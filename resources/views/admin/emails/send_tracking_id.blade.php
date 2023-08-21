@component('mail::message')
# Hello {{ucfirst($data->username)}}

Your Order has been dispatched and is on the way. Your Tracking ID is {{$data->tracking_id}}.

@component('mail::button', ['url' => 'https://www.indiapost.gov.in/'])
Track Your Order
@endcomponent

Thank you for shopping with IOA.<br>
@endcomponent
