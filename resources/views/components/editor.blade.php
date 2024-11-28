@props(['name', 'class' ])
<textarea {{ $attributes }} name="{{ $name }}" class="{{ $class ?? '' }}" id="tinyeditorinstance">{!! $slot !!}</textarea>
