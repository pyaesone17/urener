<?php

namespace Tests\Unit;

use Mockery;
use App\Url;
use App\User;
use Tests\TestCase;
use App\Services\UrlService;
use App\Exceptions\UrlNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlServiceTest extends TestCase
{
    /**
     * Set up the unit testing before the tests run
     *
     * @var string;
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function test_get_url_shortener_should_return_url_model()
    {
        $modelMock = Mockery::mock("App\Url");
        $modelMock->shouldReceive('newQuery->findOrFail')->atLeast()->once()->andReturn(new Url);
        $this->app->instance('App\Url', $modelMock); 

        $urlService = app('App\Services\UrlService');
        $url = $urlService->getUrlShortener(1);

        $this->assertInstanceOf(Url::class, $url);
    }

    public function test_add_url_shortener_should_return_url_model()
    {
        $modelMock = Mockery::mock("App\Url");

        $modelMock->shouldReceive('create')->atLeast()->once()->andReturn(new Url());
        $modelMock->shouldReceive('newQuery->whereSlug->orWhere->first')->atLeast()->once()->andReturn(null);

        $this->app->instance('App\Url', $modelMock); 

        $urlService = app('App\Services\UrlService');
        $user = new User();

        $url = $urlService->addUrlShortener("https://www.techinasia.com",$user);

        $this->assertInstanceOf(Url::class, $url);
    }

    public function test_remove_url_shortener_should_return_true()
    {
        $returnModel = Mockery::mock("App\Url");
        $returnModel->exists = true;

        $modelMock = Mockery::mock("App\Url");

        $modelMock->shouldReceive('newQuery->findOrFail')->atLeast()->once()->andReturn($returnModel);
        $returnModel->shouldReceive('delete')->atLeast()->andReturn(true);

        $this->app->instance('App\Url', $modelMock); 

        $urlService = app('App\Services\UrlService');
        $result = $urlService->removeUrlShortener(1);

        $this->assertTrue($result);
    }

    public function test_get_redirect_url_shortener_should_return_redirect_url_when_data_exist()
    {
        $modelMock = Mockery::mock("App\Url");
        $modelMock->shouldReceive('newQuery->whereSlug->orWhere->first')->atLeast()->once()->andReturn(
            new Url([ 'redirect_url' => 'https://www.techinasia.com'])
        );

        $this->app->instance('App\Url', $modelMock); 

        $urlService = app('App\Services\UrlService');
        $redirect_url = $urlService->getRedirectUrl("tia");

        $this->assertEquals($redirect_url, 'https://www.techinasia.com');
    }

    public function test_get_redirect_url_shortener_should_throw_exception_when_data_not_exist()
    {
        $modelMock = Mockery::mock("App\Url");
        $modelMock->shouldReceive('newQuery->whereSlug->orWhere->first')->atLeast()->once()->andReturn(null);

        $this->app->instance('App\Url', $modelMock); 
        $this->expectException(UrlNotFoundException::class);

        $urlService = app('App\Services\UrlService');
        $redirect_url = $urlService->getRedirectUrl("tia");
    }
}
