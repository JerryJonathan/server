<!-- <h2>User Data</h2> 
<br>

<strong>NIK: </strong>{{ $data->NIK }} <br>
<strong>Image: </strong>{{ $data->image }} <br>
<strong>Image Name: </strong>{{ $data->image_name }} <br>
<strong>Name: </strong>{{ $data->name }} <br>
<strong>Province: </strong>{{ $data->province }} <br>
<strong>Regency: </strong>{{ $data->regency }} <br>
<strong>District: </strong>{{ $data->district }} <br>
<strong>Village: </strong>{{ $data->village }} <br>
<strong>Postal: </strong>{{ $data->postal }} <br> -->

@component('mail::message')
# Input Data Form

Dear, {{$adminEmail}},

Berikut adalah data user yang berhasil diinput

Detail User: <br>
NIK: {{ $data->NIK }} <br>
Image: {{ $data->image }} <br>
Image Name: {{ $data->image_name }} <br>
Name: {{ $data->name }} <br>
Province: {{ $data->province }} <br>
Regency: {{ $data->regency }} <br>
District: {{ $data->district }} <br>
Village: {{ $data->village }} <br>
Postal: {{ $data->postal }} <br>

<!-- <x-mail::button :url="''">
Button Text
</x-mail::button> -->

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
