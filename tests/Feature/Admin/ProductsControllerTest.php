<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use SetupTrait;

    public function test_it_creates_product_with_valid_data() : void
    {
        // imitating
        $file = UploadedFile::fake()->image('test_image.jpg');
        $data = array_merge( # better for situation
            Product::factory()->make()->toArray(),
            ['thumbnail' => $file]
        );
        $slug = $data['slug'];
        $imagePath = "$slug/uploaded_image.png";

        // for Mock
        $this->mock(
            FileService::class,
            function (MockInterface $mock) use ($imagePath) {
                $mock->shouldReceive('upload')
                    ->andReturn($imagePath);
            }
        );

        $this->actingAs($this->user())
            ->post(route('admin.products.store'), $data);

        $this->assertDatabaseHas(Product::class, [
            'slug' => $slug,
            'thumbnail' => $imagePath
        ]);
    }
}
