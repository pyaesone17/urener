<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\UuidGenerator;
use App\Services\ShortIdGenerator;

class IdGeneratorTest extends TestCase
{
    /**
     * Test the uuid generator method.
     *
     * @return void
     */
    public function test_uuid_generate_should_return_token()
    {
        $uuidGenerator = new UuidGenerator();
        $token = $uuidGenerator->generate();

        $this->assertNotEmpty($token);
    }

    /**
     * Test the uuid generator method.
     *
     * @return void
     */
    public function test_youtube_style_generator_should_return_token()
    {
        $uuidGenerator = new ShortIdGenerator();
        $token = $uuidGenerator->generate();

        $this->assertNotEmpty($token);
    }
}
