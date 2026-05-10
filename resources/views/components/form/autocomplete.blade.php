@php
    $statePath = $getStatePath();
    $bindKey = $applyStateBindingModifiers('wire:model');
    $options = $field->getFluxOptions();

    $bag = new \Illuminate\View\ComponentAttributeBag(array_filter([
        $bindKey => $statePath,
        'disabled' => $isDisabled() ? 'true' : null,
        'invalid' => $errors->has($statePath) ? 'true' : null,
    ], fn ($v) => $v !== null && $v !== ''));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-flux::autocomplete :attributes="$bag">
        @foreach ($options as $value => $label)
            <x-flux::autocomplete.item :value="$value">{{ $label }}</x-flux::autocomplete.item>
        @endforeach
    </x-flux::autocomplete>
</x-dynamic-component>
