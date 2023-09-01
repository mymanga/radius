@component('mail::message')
# New Contact Form Submission

**Name:** {{$data['name']}}<br>
**Email:** {{ $data['email'] }}<br>
**Subject:** {{ $data['subject'] }}<br>
**Message:**<br>
{{ $data['message'] }}

Thanks,<br>
{{ setting('company') }}
@endcomponent
