<?php

namespace Tests\Feature;

use App\Url;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The urlService instance injection
     *
     * @var App\Model;
     */
    public $urlService;

    /**
     * The custom alias for url shortenter
     *
     * @var string;
     */
    public $alias;

    /**
     * The redirectUrl for url shortenter
     *
     * @var string;
     */
    public $redirectUrl;

    /**
     * Set up the unit testing before the tests run
     *
     * @var string;
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->urlService = app('App\Services\UrlService');
        $this->alias = "tia";
        $this->redirectUrl = "https://www.techinasia.com";
    }

    /**
     * A test for storing url shortenter.
     *
     * @return void
     */
    public function test_url_shortener_can_store_correctly()
    {
        $url = $this->urlService->addUrlShortener($this->redirectUrl, $this->user);

        $this->assertEquals($url->redirect_url, $this->redirectUrl);
        $this->assertNotNull($url->slug);
        $this->assertNull($url->alias);
    }

    /**
     * A test for storing url shortenter with alias.
     *
     * @return void
     */
    public function test_url_shortener_with_alias_can_store_correctly()
    {
        $url = $this->urlService->addUrlShortener($this->redirectUrl, $this->user, $this->alias);

        $this->assertEquals($url->redirect_url, $this->redirectUrl);
        $this->assertEquals($url->alias, $this->alias);
    }

    /**
     * A test for retriving url shortenter with slug or alias.
     *
     * @return void
     */
    public function test_url_can_retrieve_correctly()
    {
        $url = $this->urlService->addUrlShortener($this->redirectUrl, $this->user, $this->alias);
        $redirectUrlFromService = $this->urlService->getRedirectUrl($this->alias);

        $this->assertEquals($this->redirectUrl, $redirectUrlFromService);
    }

    /**
     * A test for retriving incorrect url shortenter.
     *
     * @return void
     */
    public function test_url_should_throw_exception()
    {
        $wrongAlias = "techinasia";
        $this->expectException(\App\Exceptions\UrlNotFoundException::class);
        
        $url = $this->urlService->addUrlShortener($this->redirectUrl,$this->user, $this->alias);
        $redirectUrlFromService = $this->urlService->getRedirectUrl($wrongAlias);
    }
}
