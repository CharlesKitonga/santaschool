@component('mail::message')

{{ $contacts->textarea }}

@component('mail::button', ['url' => '/'])
Visit SantaTilahm School
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
