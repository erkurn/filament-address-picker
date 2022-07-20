<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        x-data="addressPickerFormComponent({
            state: $wire.entangle('{{ $getStatePath() }}'),
            api_key: '{{ $getApiKey()}}'
        })"
        {{ $attributes->merge($getExtraAttributes())->class(['relative filament-forms-address-picker-component']) }}
        wire:ignore
    >
        <div x-ref="map_container" style="min-height: {{ $getMinHeight()}}px; width: 100%; display: block;"></div>
        @if($getDebug())
            <div class="text-sm text-gray-500" x-text="state">
            </div>
        @endif
    </div>
</x-forms::field-wrapper>
