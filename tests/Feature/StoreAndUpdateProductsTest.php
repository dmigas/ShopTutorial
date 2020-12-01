<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreAndUpdateProductsTest extends TestCase
{
    use DatabaseMigrations;

    protected $product;
    protected $productAttribute;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = \App\Models\Product::factory()->create();
        $this->productAttribute = \App\Models\ProductAttribute::factory()->create();

        $this->user = \App\Models\User::factory()->create();
    }

    public function testAuthenticatedUserCanStoreProduct(){
        $this->actingAs($this->user);

        $response = $this->post('/products', \App\Models\Product::factory()->make()->toArray());

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'name' => $this->product->name
        ]);
    }

    public function testNonAuthenticatedUserCanNotStoreProduct(){
        $response = $this->post('/products', []);

        $response->assertRedirect('login');
        $response->assertStatus(302);
    }

    //TODO
    public function testAuthenticatedUserCanAddAProduct()
    {
        /*
        $product = \App\Models\Product::factory()->make();
        $attribute = \App\Models\ProductAttribute::factory()->create();
        $value = rand();

        $postArray = $product->toArray();
        $postArray['attribute'] = $attribute;
        $postArray['value'] = $value;

        #dd($product);
        #dd($postArray);
        #dd($product->toArray()->id);

        $this->post('/products', $postArray);

        $this->get('/products/2' ) #ATTENTION: ID is hard coded for now! This can cause errors!
            ->assertSee($product->name)
            ->assertSee($attribute->name)
            ->assertSee($value);
        */
        $this->assertTrue(true);
    }

    public function testProductAttributeCanBeAttachedToProduct(){
        $value = rand();

        $this->product->productAttributes()->attach(
            $this->productAttribute->id,
            ['value' => $value]
        );

        $this->assertDatabaseHas('product_product_attribute', [
            'product_id'    => $this->product->id,
            'product_attribute_id'  => $this->productAttribute->id,
            'value'         => $value
        ]);
    }

    public function testUserCanUpdateProduct(){
        $this->actingAs($this->user);

        $updateData = [
            'name'          => 'An updated product',
            'description'   => 'I am an updated description',
            'price'         => 10,
            'amount'        => 1
        ];

        $this->patch('/products/' . $this->product->id . '/update', $updateData);

        $this->assertDatabaseHas('products', [
            'name'          => $updateData['name'],
            'description'   => $updateData['description'],
            'price'         => $updateData['price'],
            'amount'        => $updateData['amount']
        ]);
    }

    public function testProductCanNotBeUpdateWithMissingAttributes(){
        $this->actingAs($this->user);

        $updateData = [
            'name'          => 'An updated product',
            'description'   => 'I am an updated description',
            'price'         => 10
        ];

        $this->patch('/products/' . $this->product->id . '/update', $updateData);

        $this->assertDatabaseMissing('products', [
            'name'          => $updateData['name']
        ]);
    }
}
