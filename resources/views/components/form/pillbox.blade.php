@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');
    $options = $getFluxOptions();

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'variant' => $field->getFluxVariant(),
        'clearable' => $field->isFluxClearable() ? 'true' : null,
        'placeholder' => null,
        'disabled' => $isDisabled() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::pillbox :attributes="$bag">
        @foreach ($options as $value => $label)
            <x-flux::pillbox.option :value="$value">{{ $label }}</x-flux::pillbox.option>
        @endforeach
    </x-flux::pillbox>
</x-dynamic-component>
