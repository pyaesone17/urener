<?php

use Illuminate\Database\Seeder;

class UrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Url::truncate();

        factory(App\Url::class)->create([
            "alias" => "google",
            "redirect_url" => "https://www.google.com"
        ]);

        factory(App\Url::class)->create([
            "alias" => "facebook",
            "redirect_url" => "https://www.facebook.com"
        ]);

        factory(App\Url::class)->create([
            "alias" => "twitter",
            "redirect_url" => "https://www.twitter.com"
        ]);

        factory(App\Url::class)->create([
            "alias" => "tia",
            "redirect_url" => "https://www.techinasia.com"
        ]);
    }
}
