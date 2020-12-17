<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use DatabaseMigrations;

    private $product;
    private $categories;

    public function setUp(): void
    {
        parent::setUp();

        $this->categories = Category::factory()->count(5)->create();

        $this->product = Product::factory()
            ->has(ProductImage::factory()->count(1))
            ->create();

        $this->product->categories()->attach($this->categories);
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
        $response->assertSee($this->product->description);
        $response->assertSee($this->product->price);
    }

    public function testVisitorCanSeeProductCategories(){
        $response = $this->get('/products/' . $this->product->id);

        foreach($this->product->categories as $category){
            $response->assertSee($category->name);
        }
    }
}
