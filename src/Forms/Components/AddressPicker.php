<?php

namespace Erkurn\FilamentAddressPicker\Forms\Components;

use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Query\ReverseQuery;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class AddressPicker extends Field
{
    use HasPlaceholder;

    protected string $min_height;

    protected bool $debug = false;

    protected string $view = 'filament-address-picker::components.address-picker';

    public int $defaultZoom = 8;

    public array $controls = [
        'mapTypeControl' => true,
        'scaleControl' => true,
        'streetViewControl' => true,
        'rotateControl' => true,
        'fullscreenControl' => true,
        'searchBoxControl' => false,
    ];

    public array $defaultLocation = [
        'lat' => -6.914744,
        'lng' => 107.609810,
    ];

    public function getDefaultZoom(): int
    {
        return $this->defaultZoom;
    }

    public function getDefaultLocation(): string
    {
        return json_encode($this->defaultLocation, JSON_THROW_ON_ERROR);
    }

    public function setDefaultLocation(array $defaultLocation): static
    {
        $this->defaultLocation = $defaultLocation;

        return $this;
    }

    public function defaultZoom(int $defaultZoom): static
    {
        $this->defaultZoom = $defaultZoom;

        return $this;
    }

    public function getMapControls(): string
    {
        return json_encode($this->controls, JSON_THROW_ON_ERROR);
    }

    public function isSearchBoxControlEnabled(): bool
    {
        return $this->controls['searchBoxControl'];
    }

    public function mapControls(array $controls): static
    {
        $this->controls = array_merge($this->controls, $controls);

        return $this;
    }

    public function getApiKey()
    {
        return config('filament-address-picker.google_map_key');
    }

    public function getAddresses(): \Geocoder\Collection
    {
        $httpClient = new Client();
        $provider = new GoogleMaps($httpClient, null, $this->getApiKey());

        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');

        return $geocoder->reverseQuery(ReverseQuery::fromCoordinates(
            data_get($this->getState(), 'lat'),
            data_get($this->getState(), 'lng')
        ));
    }

    public function getAddress(): \Geocoder\Location
    {
        return $this->getAddresses()->first();
    }

    public function getState()
    {
        $state = parent::getState();

        if (is_array($state)) {
            return $state;
        } else {
            if (count(explode(',', $state)) > 0) {
                return [
                    'lat'   =>  floatval(explode(',', $state)[0]),
                    'lng'   =>  floatval(explode(',', $state)[1]),
                ];
            }

            try {
                return @json_decode($state, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Exception $e) {
                return [
                    'lat' => 0,
                    'lng' => 0,
                ];
            }
        }
    }

    public function getMinHeight()
    {
        return $this->min_height ?? 500;
    }

    public function minHeight(int $height)
    {
        $this->min_height = $height;

        return $this;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function showValue($value = true)
    {
        $this->debug = $value;

        return $this;
    }
}
