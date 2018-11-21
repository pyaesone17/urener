<?php

namespace App\Observers;

use App\Url;
use Illuminate\Contracts\Cache\Repository as CacheManager;

class UrlObserver
{
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
        $this->minutes =  60;
    }

    /**
     * Handle the url "created" event.
     *
     * @param  \App\Url  $url
     * @return void
     */
    public function created(Url $url)
    {
        $this->cacheManager->add($url->slug, $url->redirect_url, $this->minutes);
        if ($url->alias) {
            $this->cacheManager->add($url->alias, $url->redirect_url, $this->minutes);
        }
    }

    /**
     * Handle the url "updated" event.
     *
     * @param  \App\Url  $url
     * @return void
     */
    public function updated(Url $url)
    {
        $this->cacheManager->set($url->slug, $url->redirect_url, $this->minutes);
        if ($url->alias) {
            $this->cacheManager->set($url->alias, $url->redirect_url, $this->minutes);
        }
    }

    /**
     * Handle the url "deleted" event.
     *
     * @param  \App\Url  $url
     * @return void
     */
    public function deleted(Url $url)
    {
        $this->cacheManager->forget($url->slug);
        if ($url->alias) {
            $this->cacheManager->forget($url->alias);
        }
    }

    /**
     * Handle the url "restored" event.
     *
     * @param  \App\Url  $url
     * @return void
     */
    public function restored(Url $url)
    {
        $this->cacheManager->set($url->slug, $url->redirect_url, $this->minutes);
        if ($url->alias) {
            $this->cacheManager->set($url->alias, $url->redirect_url, $this->minutes);
        }
    }

    /**
     * Handle the url "force deleted" event.
     *
     * @param  \App\Url  $url
     * @return void
     */
    public function forceDeleted(Url $url)
    {
        $this->cacheManager->forget($url->slug);
        if ($url->alias) {
            $this->cacheManager->forget($url->alias);
        }
    }
}
