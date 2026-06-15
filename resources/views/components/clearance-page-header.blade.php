@props([
    'title',
    'subtitle' => null,
])

<div class="clearance-shared-page-header__text">
    <h1 class="clearance-shared-page-header__title">{{ $title }}</h1>
    @if ($subtitle)
        <p class="clearance-shared-page-header__subtitle">{{ $subtitle }}</p>
    @endif
</div>
