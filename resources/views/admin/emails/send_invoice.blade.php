@component('mail::message')
# Invoice

Your IOA invoice for your order is available. Please find the PDF document attached at the bottom of this email.
<br>
<br>
Name : {{$data->username}}
<br>
Invoice No : {{$data->invoice_no}}
<br>
Order Date : {{date('d/m/Y',strtotime($data->created_at))}}
<br>
Payment ID : {{$data->payment_id}}

@endcomponent
