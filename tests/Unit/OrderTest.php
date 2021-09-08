<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    function test_an_order_consists_of_products()
    {
        $order = new Order;

        $product = new Product('Fallout 4', 59);
        $product2 = new Product('GTA V', 49);

        $order->add($product);
        $order->add($product2);

        $this->assertEquals(2, count($order->products()));
    }

    function test_an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = new Order;

        $product = new Product('Fallout 4', 30);
        $product2 = new Product('GTA V', 60);

        $order->add($product);
        $order->add($product2);

        $this->assertEquals(90, $order->total());
    }
}
