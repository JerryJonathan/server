<x-mail::message>
# Update Data Form

Dear, {{$adminEmail}},

Berikut adalah data user yang sudah diupdate

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
</x-mail::message>
