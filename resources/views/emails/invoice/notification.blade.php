@component('mail::message')
# Invoice Notification

Dear {{ $firstname }},

Your invoice no: {{ $invoiceNumber }} of amount {{ $amount }} has been {{ $status }}.

You can view it [here]({{ $url }}).

Thanks,
{{ setting('company') }}
@endcomponent

