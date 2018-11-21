<?php

namespace App\Listeners;

use \App\VisitorLog as VisitorLogModel;
use App\Events\UrlVisitedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UrlVisitedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(VisitorLogModel $visitorLogModel)
    {
        $this->visitorLogModel = $visitorLogModel;
    }

    /**
     * Handle the event.
     *
     * @param  UrlVisitedEvent  $event
     * @return void
     */
    public function handle(UrlVisitedEvent $event) : void
    {
        $this->visitorLogModel->create([
            'slug' => $event->slug,
            'ip_address' => $event->ip,
            'client' => $event->client,            
            'redirect_url' => $event->redirectUrl,
        ]);
    }
}
