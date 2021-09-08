<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $product;

    public function setUp() : void
    {
        $this->product = new Product('Grand Theft Auto V', 79);
    }

    function test_a_product_has_a_name() {
        $this->assertEquals('Grand Theft Auto V', $this->product->name());
    }

    function test_a_product_has_a_cost() {
        $this->assertEquals(79, $this->product->cost());
    }
}
