<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlShortenerControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Admin should able to create the url.
     *
     * @return void
     */
    public function test_url_create_success()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Admin should able to create the url.
     *
     * @return void
     */
    public function test_url_create_should_failed_when_repeated_alias()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);

        $response->assertStatus(201);

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);
        $response->assertStatus(422);
    }

    /**
     * Admin should able to update the url.
     *
     * @return void
     */
    public function test_url_update_success()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);

        $response->assertStatus(201);
        $createdId = $response->json()["data"]["id"];

        $response = $this->json('PATCH', "/admin/urls/{$createdId}", [
            'redirect_url' => 'https://www.twitter.com'
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'data' => ['redirect_url' => "https://www.twitter.com"]
        ]);

        $response = $this->json('PATCH', "/admin/urls/{$createdId}", [
            'redirect_url' => 'https://www.instagram.com',
            'alias' => 'instagram'
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'alias' => 'instagram',
                'redirect_url' => "https://www.instagram.com"
            ]
        ]);
    }

    /**
     * Admin should able to delete the url.
     *
     * @return void
     */
    public function test_url_delete_success()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);

        $createdId = $response->json()["data"]["id"];
        $response = $this->json('DELETE', "/admin/urls/{$createdId}");

        $response->assertStatus(200);
    }

    /**
     * Admin should able to list the created urls.
     *
     * @return void
     */
    public function test_url_list_success()
    {
        Passport::actingAs(
            factory(User::class)->create()
        );

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.google.com'
        ]);

        $response = $this->json('POST', '/admin/urls', [
            'redirect_url' => 'https://www.twitter.com'
        ]);

        $response = $this->json('GET', "/admin/urls/");
    
        $response->assertStatus(200)
            ->assertJsonCount(2, "data");
    }
}
