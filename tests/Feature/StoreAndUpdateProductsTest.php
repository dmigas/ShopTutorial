<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAndUpdateProductsTest extends TestCase
{
    use DatabaseMigrations;

    protected $product;
    protected $user;
    protected $testUpdateData;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = \App\Models\Product::factory()->create();
        $this->user = \App\Models\User::factory()->create();
        $this->categories = \App\Models\Category::factory()->count(3)->create();

        $this->testUpdateData = [
            [ #Fields are missing
                'name'          => 'An updated product',
                'description'   => 'I am an updated description',
                'price'         => 10
            ]
        ];
    }

    public function testAuthenticatedUserCanStoreProductWithImage(){
        $this->actingAs($this->user);

        Storage::fake('local');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/products', [
            'name' => 'Test',
            'description' => 'Some description',
            'price' => 1,
            'amount' => 1,
            'categories' => [1],
            'img' => $file
        ]);

        Storage::disk('local')->assertExists('public/images/' . $file->hashName());

        $response->assertSessionHasNoErrors();
    }

    public function testNonAuthenticatedUserCanNotStoreProduct(){
        $response = $this->post('/products', []);

        $response->assertRedirect('login');
        $response->assertStatus(302);
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

    public function testProductCanNotBeUpdatedWithMissingAttributes(){
        $this->actingAs($this->user);

        foreach($this->testUpdateData as $data){
            $this->patch('/products/' . $this->product->id . '/update', $data);

            $this->assertDatabaseMissing('products', [
                'name' => $data['name']
            ]);
        }
    }
}
