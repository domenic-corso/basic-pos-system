<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;

class ProductTest extends TestCase
{

	/* Returns an array of properties that should always be accepted,
	no matter what. Other test functions should call on this and
	change the array values specifid to their tests. */
	private static function getAccpetableProperties () : array {
		return [
			'name' => 'Test Coffee',
			'short_name' => 'TEST COFF',
			'category_id' => 1,
			'price_definition_id' => 1
		];
	}

	/* This test should always pass as it is based off acceptable
	proprerites. */
    public function testAcceptableProduct () {
    	$this->assertTrue(Product::validateProduct(self::getAccpetableProperties()));
    }

    public function testAcceptableUnacceptableName () {
    	$properties = self::getAccpetableProperties();
    	$acceptableNames = array('TestCoffee', 'Test Coffee', '2Burger', '2 Burger\'s', 'Hot Chips & Pie', 'pie');
    	$unacceptableNames = array('Latte!', '#2 Hot Dog', ' ', '', str_repeat('h', 61), null, '2c');

    	foreach ($acceptableNames as $an) {
    		$properties['name'] = $an;
    		$this->assertTrue(Product::validateProduct($properties));
    	}

    	foreach ($unacceptableNames as $un) {
    		$properties['name'] = $un;
    		$this->assertFalse(Product::validateProduct($properties));
    	}
    }

    public function testAcceptableUnacceptableShortName () {
    	$properties = self::getAccpetableProperties();
    	$acceptableShortNames = array('TESTCOFFEE', 'TEST COFFEE', '2 BURG', '2 BURGER\'S', 'CHIPS & PIE', 'PIE');
    	$unacceptableShortNames = array('LATTE!', '#2 HOT DOG', '', ' ', str_repeat('h', 13), null, '2C');

    	foreach ($acceptableShortNames as $asn) {
    		$properties['short_name'] = $asn;
    		$this->assertTrue(Product::validateProduct($properties));
    	}

    	foreach ($unacceptableShortNames as $usn) {
    		$properties['short_name'] = $usn;
    		$this->assertFalse(Product::validateProduct($properties));
    	}
    }

    public function testAcceptableUnacceptableFixedPrice () {
    	$properties = self::getAccpetableProperties();
    	$acceptableFixedPrices = array(0.00, 0.50, 2.50, 45.95, '', null);
        $unacceptableFixedPrices = array(-0.05, 100, 'e');

    	foreach ($acceptableFixedPrices as $afp) {
    		$properties['fixed_price'] = $afp;
    		$this->assertTrue(Product::validateProduct($properties));
    	}

        foreach ($unacceptableFixedPrices as $ufp) {
            $properties['fixed_price'] = $ufp;
            $this->assertFalse(Product::validateProduct($properties));
        }
    }

    public function testCategoryNonExistence () {
    	$properties = self::getAccpetableProperties();

    	/* Test out of range. */
    	$properties['category_id'] = -1;
    	$this->assertFalse(Product::validateProduct($properties));

    	/* Test against an existing category if it exists. NOTE: should be using
    	a testing database here. */
    	if (\App\Category::count() > 0) {
	    	$properties['category_id'] = \App\Category::all()[0]->id;
	    	$this->assertTrue(Product::validateProduct($properties));
    	}
    }

    public function testPriceDefinitionExistence () {
    	$properties = self::getAccpetableProperties();

    	/* Test out of range. */
    	$properties['price_definition_id'] = -1;
    	$this->assertFalse(Product::validateProduct($properties));

    	/* Test against an existing category if it exists. NOTE: should be using
    	a testing database here. */
    	if (\App\PriceDefinition::count() > 0) {
	    	$properties['price_definition_id'] = \App\PriceDefinition::all()[0]->id;
	    	$this->assertTrue(Product::validateProduct($properties));
    	}
    }

    public function testPrices () {
        $properties = self::getAccpetableProperties();

        /* NOTE: should be using a testing database here. */
        if (\App\PriceDefinition::count() > 0) {

            /* Provide only a price definition. */
            $properties['price_definition_id'] = \App\PriceDefinition::all()[0]->id;
            $properties['fixed_price'] = null;
            $this->assertTrue(Product::validateProduct($properties));

            /* Provide only a fixed price. */
            $properties['price_definition_id'] = null;
            $properties['fixed_price'] = 6.50;
            $this->assertTrue(Product::validateProduct($properties));

            /* Provide both. */
            $properties['price_definition_id'] = \App\PriceDefinition::all()[0]->id;
            $properties['fixed_price'] = 6.50;
            $this->assertTrue(Product::validateProduct($properties));

            /* Do not provide any. This one should fail */
            $properties['price_definition_id'] = null;
            $properties['fixed_price'] = null;
            $this->assertFalse(Product::validateProduct($properties));
        }
    }

    public function testRoundTo5Cents () {
        $properties = self::getAccpetableProperties();
        $properties['price_definition_id'] = null;

        /* A completely valid fixed price with no rounding expected. */
        $properties['fixed_price'] = 5;
        $appliedProduct = Product::applyProperties(new Product(), $properties);
        $this->assertEquals($appliedProduct->fixed_price, 5.00);

        $properties['fixed_price'] = 0.03;
        $appliedProduct = Product::applyProperties(new Product(), $properties);
        $this->assertEquals($appliedProduct->fixed_price, 0.05);

        $properties['fixed_price'] = 0.02;
        $appliedProduct = Product::applyProperties(new Product(), $properties);
        $this->assertEquals($appliedProduct->fixed_price, 0);

        $properties['fixed_price'] = 21.23;
        $appliedProduct = Product::applyProperties(new Product(), $properties);
        $this->assertEquals($appliedProduct->fixed_price, 21.25);
    }

    public function testPrioritizePriceDefinition () {
        $properties = self::getAccpetableProperties();

        /* NOTE: should be using a testing database here. */
        if (\App\PriceDefinition::count() > 0) {

            /* Provide only a price definition. */
            $properties['price_definition_id'] = \App\PriceDefinition::all()[0]->id;
            $properties['fixed_price'] = null;
            $appliedProduct = Product::applyProperties(new Product(), $properties);
            $this->assertEquals($appliedProduct->price_definition_id, $properties['price_definition_id']);
            $this->assertEquals($appliedProduct->fixed_price, null);

            /* Provide only a fixed price. */
            $properties['price_definition_id'] = null;
            $properties['fixed_price'] = 6.50;
            $appliedProduct = Product::applyProperties(new Product(), $properties);
            $this->assertEquals($appliedProduct->price_definition_id, null);
            $this->assertEquals($appliedProduct->fixed_price, $properties['fixed_price']);

            /* Provide both. */
            $properties['price_definition_id'] = \App\PriceDefinition::all()[0]->id;
            $properties['fixed_price'] = 6.50;
            $appliedProduct = Product::applyProperties(new Product(), $properties);
            $this->assertEquals($appliedProduct->price_definition_id, $properties['price_definition_id']);
            $this->assertEquals($appliedProduct->fixed_price, null);

        }
    }
}
