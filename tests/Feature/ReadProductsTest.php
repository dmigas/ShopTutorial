<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use DatabaseMigrations;

    private $product;
    private $productAttributes;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();

        $this->productAttributes = ProductAttribute::factory(5)->create();

        $this->product->productAttributes()->attach(
            $this->productAttributes,
            ['value' => rand()]
        );
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVisitorCanSeeProducts()
    {
        $response = $this->get('/products');

        $response->assertSee($this->product->name);
    }

    public function testVisitorCanSeeSingleProduct(){
        $response = $this->get('/products/' . $this->product->id);

        $response->assertSee($this->product->name);
    }

    public function testVisitorCanSeeAssociatedProductAttributesWithValues(){
        $response = $this->get('/products/' . $this->product->id);

        foreach($this->product->productAttributes as $attribute){
            $response->assertSee($attribute->name);
            $response->assertSee($attribute->pivot->value);
        }
    }
}
