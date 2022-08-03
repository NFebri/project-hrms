@props(['breadcrumb'])

<div class="section-header-breadcrumb">
    @foreach ($breadcrumb as $item)
    <div class="breadcrumb-item">{{ __($item) }}</div>
    @endforeach
</div>