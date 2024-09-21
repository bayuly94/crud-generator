@props([
    'label' => '',
    'name'  => '',
    'value' => '',
])
<div class="form-group mb-2 mb20">
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
    <input type="text" name="{{ $name }}" class="form-control @error('code') is-invalid @enderror" value="{{ old($name, $value ?? '') }}" id="{{ $name ?? '' }}" placeholder="{{ $label ?? '' }}">
    
    @error($name)
    <div class="invalid-feedback" role="alert"><strong>{{ $message ?? '' }}</strong></div>
    @enderror

</div>