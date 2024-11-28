@props(['title', 'icon' => 'ti ti-calendar', 'url', 'active' => ''])

<li class="nav-item">
    <a class="nav-link menu-link {{ $active ? 'active' : '' }}" href="{{ $url }}">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ __($title) }}</span>
    </a>
</li>
