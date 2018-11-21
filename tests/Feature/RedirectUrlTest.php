<?php

namespace Tests\Feature;

use App\Url;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedirectUrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the unit testing before the tests run
     *
     * @var string;
     */
    public function setUp()
    {
        parent::setUp();
        $this->urlService = app('App\Services\UrlService');
    }

    /**
     * Test the site should redirect the user to the intended url.
     *
     * @return void
     */
    public function test_redirect_correctly()
    {
        $user = factory(User::class)->create();
        $urlData = $this->urlService->addUrlShortener("https://www.techinasia.com", $user, "tia");

        $response = $this->get("/{$urlData->alias}");
        $response->assertRedirect($urlData->redirect_url);
    }
}
