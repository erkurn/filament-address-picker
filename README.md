<img src="https://banners.beyondco.de/Filament%20Address%20Picker.png?theme=light&packageManager=composer+require&packageName=erkurn%2Ffilament-address-picker&pattern=anchorsAway&style=style_2&description=Google+Map+API&md=1&showWatermark=0&fontSize=125px&images=globe&widths=300&heights=300" />

# Pick Address For Filament Field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/erkurn/filament-address-picker.svg?style=flat-square)](https://packagist.org/packages/erkurn/filament-address-picker)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/erkurn/filament-address-picker/run-tests?label=tests)](https://github.com/erkurn/filament-address-picker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/erkurn/filament-address-picker/Check%20&%20fix%20styling?label=code%20style)](https://github.com/erkurn/filament-address-picker/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/erkurn/filament-address-picker.svg?style=flat-square)](https://packagist.org/packages/erkurn/filament-address-picker)

A Filament Field to enable pick location in google map and return geo coordinates.
For initial location you can use coordinate or address.

this packages require Google Map API and using this service : 
- Maps JavaScript API
- Places API

## Installation

You can install the package via composer:

```bash
composer require erkurn/filament-address-picker
```

## Usage

```php
<?php

class FilamentResource extends Resource
{
    public static function form(Form $form)
    {
        return $form->schema([
            AddressPicker::make('coordinate')
                ->setDefaultLocation([ // Set Default Location
                    'lat' =>    -6.914744,
                    'lng'  =>  107.609810
                ])
                ->mapControls([ // Map Controls
                    'mapTypeControl' => true,
                    'scaleControl' => true,
                    'streetViewControl' => false,
                    'rotateControl' => true,
                    'fullscreenControl' => true,
                    'searchBoxControl' => true
                ])
                ->minHeight(300) // Min Height In Pixels
                ->defaultZoom(16) // Default Zoom
                ->placeholder("Search Address") // Default Search
                ->afterStateUpdated(function ($state, $component, $set) {
                    $location = $component->getAddress(); // Get Details Location After Pick Location
                    
                    $location->getAdminLevels()->get(4)->getName(); // Post Code
                    $location->getStreetName(); // Street Name
                    $location->getStreetNumber(); // Street Number
                })
                ->placeholder("Search Address")
        ]);  
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/erkurn/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rezza Kurniawan](https://github.com/erkurn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
