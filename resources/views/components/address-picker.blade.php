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
            api_key: '{{ $getApiKey() }}',
            zoom: {{$getDefaultZoom()}},
            controls: {{$getMapControls()}},
            defaultLocation: {{ $getDefaultLocation() }}
        })"
        {{ $attributes->merge($getExtraAttributes())->class(['relative filament-forms-address-picker-component']) }}
        wire:ignore
    >
        <div>
            @if($isSearchBoxControlEnabled())
                <input x-ref="map_search" type="text" placeholder="Search Location" style="margin: 10px 0 10px 0; width: 50%;" class="block transition duration-75 rounded-md shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300"/>
            @endif
            <div x-ref="map_container" style="min-height: {{ $getMinHeight()}}px; width: 100%; display: block;"></div>
        </div>
    </div>
</x-forms::field-wrapper>
