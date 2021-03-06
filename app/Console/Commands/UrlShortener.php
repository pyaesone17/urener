<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\UrlServiceInterface;
use App\ValidationRules\UrlFormRule;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

class UrlShortener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urlshortener:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding the url shortener via command line';

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
    public function handle(UrlServiceInterface $urlService, Factory $validator) : void
    {
        $customSlug = null;
        $redirectUrl = $this->ask("Please add the redirected url. Example ('https://techinasia.com')");

        $data = ['redirect_url' => $redirectUrl];

        if ($this->confirm('Do you wish to add custom slug?')) {
            $customSlug = $this->ask("Please add custom slug");
            if($customSlug) {
                $data['alias'] = $customSlug;
            }
        }

        try {
            $result = $validator->make(
                $data,
                UrlFormRule::rules("POST")
            )->validate();

            $url = $urlService->addUrlShortener($redirectUrl, null, $customSlug);

            $this->info("Successfully added a new shorten url");
        } catch (ValidationException $validationException) {
            $errors = $validationException->validator->errors();

            foreach ($errors->all() as $message) {
                $this->error($message);
            }
        }
    }
}
