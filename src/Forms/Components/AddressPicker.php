<?php

namespace Erkurn\FilamentAddressPicker\Forms\Components;

use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;

class AddressPicker extends Field
{
    use HasPlaceholder;

    protected string $api_key;

    protected string $min_height;

    protected bool $debug = false;

    protected string $view = 'filament-address-picker::components.address-picker';

    public function getApiKey(): string
    {
        return $this->api_key;
    }

    public function apiKey(string $api_key)
    {
        $this->api_key = $api_key;

        return $this;
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
