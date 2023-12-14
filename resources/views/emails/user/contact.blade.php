<x-mail::message>
# Nouvelle demande de contact

Une nouvelle demande de contact pour la ressource <a href="{{ route('resource.show', ['slug' => $resource->slug, 'resource' => $resource]) }}">{{$resource->title}}</a>
- Name : {{ $data['sender']->name }}
- Email : {{ $data['sender']->email }}

**Message :**<br/>
{{ $data['message'] }}

</x-mail::message>

