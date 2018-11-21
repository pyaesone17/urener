<?php 

namespace App\Contracts;

use App\Url;
use Illuminate\Foundation\Auth\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UrlServiceInterface
{
    public function addUrlShortener(string $alias, User $user,string $url):Url;

    public function getUrlShortener(string $id):Url;

    public function getUrlShorteners():LengthAwarePaginator;
    
    public function removeUrlShortener(string $id):bool;

    public function updateUrlShortener(string $id, array $data):Url;

    public function getRedirectUrl(string $slug):string;
}
