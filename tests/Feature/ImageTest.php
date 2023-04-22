<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ImageTest extends TestCase
{
    private string $filename;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filename = 'foto.png';
    }

    public function test_post_store_file_fail_if_image_is_not_present(): void
    {
        $response = $this->post(route('image.store'));

        $response->assertRedirect(route('home'));

        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'image' => 'The image field is required.',
        ]);
    }

    public function test_post_store_file_is_saved_successfully(): void
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image($this->filename);

        $response = $this->post(route('image.store'), ['image' => $file]);

        $response->assertRedirect(route('home'));

        $response->assertSessionHas('output');

        $response->assertStatus(302);

        Storage::disk('images')->exists($this->filename);
    }

    public function test_image_is_resized_to_1440_x_920_when_saved()
    {
        Storage::fake('images');

        $file = UploadedFile::fake()->image($this->filename);

        $this->post(route('image.store'), ['image' => $file]);

        Storage::disk('images')->exists($this->filename);

        $path = storage_path('/app/public/images/'.$this->filename);

        $image = Image::make($path);

        $this->assertEquals(1440, $image->width());

        $this->assertEquals(920, $image->height());
    }

    public function test_homepage_returns_correct_view_with_inertia_component()
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                ->component('App')
            );
    }

}
