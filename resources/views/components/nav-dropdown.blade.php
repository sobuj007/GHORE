@props(['id', 'icon' => 'ti ti-calendar', 'title', 'active' => ''])

<li class="nav-item">
    <a class="nav-link menu-link" href="#{{ $id }}" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="{{ $id }}">
        <i class="{{ $icon }}"></i> <span data-key="t-dashboards">{{ __($title) }}</span>
    </a>
    <div class="collapse menu-dropdown {{ $active ? 'show' : '' }}" id="{{ $id }}">
        <ul class="nav nav-sm flex-column">
          {!! $slot !!}
        </ul>
    </div>
</li>
