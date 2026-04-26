@props([
    'title',
    'subtitle' => null,
])

<div class="highguy-shared-page-header__text">
    <h1 class="highguy-shared-page-header__title">{{ $title }}</h1>
    @if ($subtitle)
        <p class="highguy-shared-page-header__subtitle">{{ $subtitle }}</p>
    @endif
</div>
