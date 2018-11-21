<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Pagination\Paginator;
use App\Contracts\UrlServiceInterface;

class UrlShortenerList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urlshortener:list {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the url shortener';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(UrlServiceInterface $urlService)
    {
        // Explicitly Set the current page of 
        // Laravel paginator for console command
        Paginator::currentPageResolver(function () {
            return $this->argument('page');
        });

        $headers = ['Slug', 'Alias', 'Redirect Url'];

        $urls = $urlService->getUrlShorteners();

        // Map the urls collection to the array to use in 
        // table view
        $newUrls = $urls->map(function ($url) {
            return [
                $url->slug,
                $url->alias,
                $url->redirect_url
            ];
        });
    
        $this->table($headers, $newUrls);
    }
}
