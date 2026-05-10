@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');
    $accept = $getFluxAccept();

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'accept' => $accept !== null ? implode(',', $accept) : null,
        'multiple' => $shouldFluxMultiple() ? 'true' : null,
        'max-size' => $getFluxMaxSize(),
        'disabled' => $isDisabled() ? 'true' : null,
        'required' => $isRequired() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::file-upload :attributes="$bag">
        <x-flux::file-upload.dropzone />
    </x-flux::file-upload>
</x-dynamic-component>
