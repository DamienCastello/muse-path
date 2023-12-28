<x-mail::message>
# Nouveau feedback

Un nouveau feedback pour la track <a href="{{ route('track.show', ['track' => $track]) }}">{{$track->title}}</a>
- Name : {{ $data['sender']->name }}
- Email : {{ $data['sender']->email }}

**Message :**<br/>
{{ $data['message'] }}

</x-mail::message>

