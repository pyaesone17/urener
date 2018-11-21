<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\UrlService;
use App\Http\Controllers\Controller;
use App\Contracts\UrlServiceInterface;
use App\Events\UrlVisitedEvent;
use Illuminate\Contracts\Cache\Repository as CacheManager;
use Illuminate\Contracts\Events\Dispatcher;

class UrlShortenerController extends Controller
{
    public function __construct(CacheManager $cacheManager, Dispatcher $eventDispatcher)
    {
        $this->cacheManager = $cacheManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
    * Redirect the user to the external service.
    *
    * @return \Illuminate\Http\Response
    */

    public function __invoke(string $slug, Request $request, UrlServiceInterface $urlService)
    {
        $redirectUrl = $this->cacheManager->get($slug, function () use ($slug, $urlService) {
            return $urlService->getRedirectUrl($slug);
        });
 
        $this->eventDispatcher->fire(new UrlVisitedEvent(
            $request->ip(),
            $slug,
            $redirectUrl,
            $request->server('HTTP_USER_AGENT')
        ));

        return redirect()->away($redirectUrl);
    }
}
