<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UrlVisitedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Visitor's ipaddress
     *
     * @var string
     */
    public $ip;

    /**
     * Visitor's shorten url
     *
     * @var string
     */
    public $slug;

    /**
     * Visitor's next url 
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * Visitor's useragent 
     *
     * @var string
     */
    public $client;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $ip, string $slug, string $redirectUrl, string $client)
    {
        $this->ip = $ip;
        $this->slug = $slug;
        $this->client = $client;   
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
