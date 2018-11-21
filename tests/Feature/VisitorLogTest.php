<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitorLogTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_visitor_log_should_persit_to_database()
    {
        $user = factory(User::class)->create();
        $urlService = app('App\Services\UrlService');
        $url = $urlService->addUrlShortener("https://www.techinasia.com", $user);

        $this->get("/{$url->slug}");
        
        $this->assertDatabaseHas('visitor_logs', [
            'redirect_url' => 'https://www.techinasia.com'
        ]);
    }
}
