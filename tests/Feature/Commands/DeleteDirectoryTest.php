<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteDirectoryTest extends TestCase
{

    public function test_command_clear_directory_images_in_storage_app_public_executed_succesfully(): void
    {
        Storage::fake('images');

        $filename = "file.txt";

        $directory = 'images';

        Storage::disk($directory)->put($filename, 'Content');

        Storage::disk($directory)->assertExists($filename);

        $this->artisan("clean:directory {$directory}")
            ->assertSuccessful()
            ->assertExitCode(0);

        Storage::disk($directory)->assertMissing($filename);
    }
}
