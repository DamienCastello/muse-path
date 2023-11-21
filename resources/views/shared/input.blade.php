@php
$label ??= null;
$type ??= 'text';
$class ??= null;
$name ??= '';
$placeholder ??= '';
$oldValue ??= '';
$area ??= false;
@endphp


<div @class(['form-group', $class])>
    <label for="{{$name}}">{{$label}}</label>

    @if($area)
        <textarea class="form-control @error($name) is-invalid @enderror" name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder}}">{{$oldValue}}</textarea>
    @else
        <input class="form-control @error($name) is-invalid @enderror" type="{{$type}}" name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder}}" value="{{$oldValue}}">
    @endif
    @error($name)
    <p class="text-danger">
        {{$message}}
    </p>
    @enderror

</div>
