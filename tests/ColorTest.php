<?php

require_once __DIR__.'/../vendor/autoload.php';

use NiclasHedam\Color;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    public $color1;
    public $color2;
    public $color3;
    public $color4;

    public $color5;
    public $color6;

    public function __construct()
    {
        $this->color1 = Color::fromRGB(0, 0, 0); //Black
        $this->color2 = Color::fromRGB(255, 255, 255); //White
        $this->color3 = Color::fromRGB(255, 153, 102); //Atomic Tangerine
        $this->color4 = Color::fromRGB(102, 255, 255); //Light blue

        $this->color5 = Color::fromCMYK(47, 48, 0, 68);
        $this->color6 = Color::fromCMYK(0, 85, 85, 49);
    }

    public function testLikeliness()
    {
        $this->assertEquals($this->color1->differenceBetween($this->color2), 100); //100
        $this->assertEquals($this->color2->differenceBetween($this->color1), 100); //100
        $this->assertEquals($this->color3->differenceBetween($this->color2), 41.6333);
        $this->assertEquals($this->color2->differenceBetween($this->color3), 41.6333);
        $this->assertEquals($this->color3->differenceBetween($this->color4), 54.1603);
    }

    public function testName()
    {
        $this->assertEquals($this->color1->name(), 'Black');
        $this->assertEquals($this->color2->name(), 'White');
        $this->assertEquals($this->color3->name(), 'Atomic Tangerine');
        $this->assertEquals($this->color4->name(), false);
    }

    public function testConversion()
    {
        $this->assertEquals($this->color5->toRGB(), ['r' => 43, 'g' => 42, 'b' => 82]);
        $this->assertEquals($this->color6->toRGB(), ['r' => 130, 'g' => 20, 'b' => 20]);

        $this->assertEquals($this->color1->toHEX(), '#000000');
        $this->assertEquals($this->color2->toHEX(), '#FFFFFF');
    }

    public function testInvalids()
    {
        try {
            Color::fromRGB(215, 242, 275);
            $this->fail();
        } catch (Exception $e) {
        }

        try {
            Color::fromRGB(-252, 242, 35);
            $this->fail();
        } catch (Exception $e) {
        }

        try {
            $color = Color::fromCMYK(105, 45, 23, 66);
            $this->fail();
        } catch (Exception $e) {
        }
    }
}
