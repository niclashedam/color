<?php

namespace NiclasHedam;

use Exception;

class Color
{
    public $red;
    public $green;
    public $blue;

    private function __construct($red, $green, $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public static function fromRGB($red, $green, $blue)
    {
        if ($red < 0 || $red > 255) {
            throw new Exception('Red color invalid', 1);
        }
        if ($green < 0 || $green > 255) {
            throw new Exception('Green color invalid', 1);
        }
        if ($blue < 0 || $blue > 255) {
            throw new Exception('Blue color invalid', 1);
        }
        return new self($red, $green, $blue);
    }

    public static function fromCMYK($cyan, $magenta, $yellow, $key)
    {
        if ($cyan < 0 || $cyan > 100) {
            throw new Exception('Cyan color invalid', 1);
        }
        if ($magenta < 0 || $magenta > 100) {
            throw new Exception('Magenta color invalid', 1);
        }
        if ($yellow < 0 || $yellow > 100) {
            throw new Exception('Yellow color invalid', 1);
        }
        if ($key < 0 || $key > 100) {
            throw new Exception('Key color invalid', 1);
        }
        $cyan = $cyan / 100;
        $magenta = $magenta / 100;
        $yellow = $yellow / 100;
        $key = $key / 100;

        $r = 1 - ($cyan * (1 - $key)) - $key;
        $g = 1 - ($magenta * (1 - $key)) - $key;
        $b = 1 - ($yellow * (1 - $key)) - $key;

        return new self(round($r * 255), round($g * 255), round($b * 255));
    }

    public function differenceBetween(Color $color)
    {
        return round(sqrt(
                pow($this->red - $color->red, 2)
            + pow($this->green - $color->green, 2)
            + pow($this->blue - $color->blue, 2)
        ) / 441.6729559300637 * 100, 4);
    }

    public function toHEX()
    {
        return strtoupper('#'.sprintf('%02x', $this->red).sprintf('%02x', $this->green).sprintf('%02x', $this->blue));
    }

    public function toCMYK()
    {
        $c = (255 - $this->red) / 255.0 * 100;
        $m = (255 - $this->green) / 255.0 * 100;
        $y = (255 - $this->blue) / 255.0 * 100;

        $b = min([$c, $m, $y]);
        $c = round($c - $b, 4);
        $m = round($m - $b, 4);
        $y = round($y - $b, 4);

        return ['c' => $c, 'm' => $m, 'y' => $y, 'k' => $b];
    }

    public function toRGB()
    {
        return [
            'r' => $this->red,
            'g' => $this->green,
            'b' => $this->blue,
        ];
    }

    public function name()
    {
        return ColorName::nameFromRGB($this->red, $this->green, $this->blue);
    }
}
