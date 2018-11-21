<?php

namespace App\Services;

use App\Url;
use Illuminate\Foundation\Auth\User;
use App\Contracts\UrlServiceInterface;
use App\Contracts\IdGeneratorInterface;
use App\Exceptions\UrlNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class UrlService implements UrlServiceInterface
{
    public function __construct(Url $urlModel, IdGeneratorInterface $idGenerator)
    {
        $this->urlModel = $urlModel;
        $this->idGenerator = $idGenerator;
    }

    /**
     * Get the specific url shortener
     *
     * @param string $id
     * @return Url
     */
    public function getUrlShortener(string $id):Url
    {
        $url = $this->urlModel->newQuery()->findOrFail($id);
        return $url;
    }


    /**
     * List all of the available url shorteners
     *
     * @param
     * @return array
     */
    public function getUrlShorteners():LengthAwarePaginator
    {
        $urls = $this->urlModel->newQuery()->paginate();
        return $urls;
    }
    
    /**
     * Store the url shortener to the database
     *
     * @param string $url
     * @param string $alias
     * @return Url
     */
    public function addUrlShortener(string $url, User $user=null, string $alias=null):Url
    {
        $slug = "";

        // Check the edge case for generated slug is already created
        // in database, If so, we will regenerate until we get a new slug

        while (true) {
            $slug = $this->idGenerator->generate();
            $exsitedUrl = $this->getUrlBySlugOrAlias($slug);
            if (! $exsitedUrl) {
                break;
            }
        }

        $url = $this->urlModel->create([
            'slug' => $slug,
            'redirect_url' => $url,
            'alias' => $alias,
            'user_id' => $user !== null ? $user->id : null
        ]);

        return $url;
    }

    /**
     * Remove the url shortener from the database
     *
     * @param string $id
     * @return boolean
     */
    public function removeUrlShortener(string $id):bool
    {
        $url = $this->getUrlShortener($id);
        return $url->delete();
    }

    /**
     * Update the specific url shortener from the database
     *
     * @param string $id
     * @param array $data
     * @return Url
     */
    public function updateUrlShortener(string $id, array $data):Url
    {
        $url = $this->getUrlShortener($id);
        $url->update($data);
        
        return $url;
    }

    /**
     * check if the database has data and return if present
     * Otherwise it will throw the exception and response error
     *
     * @param string $slug
     * @return string
     */
    public function getRedirectUrl(string $slug):string
    {
        $urlData = $this->getUrlBySlugOrAlias($slug);

        if ($urlData !== null) {
            return $urlData->redirect_url;
        }
        throw new UrlNotFoundException("Url Not found");
    }

    /**
     * Get the url data from the database
     * using slug or alias
     *
     * @param string $slug
     * @return string
     */
    protected function getUrlBySlugOrAlias(string $slug):?Url
    {
        $query = $this->urlModel->newQuery();
        $urlData = $query->whereSlug($slug)->orWhere("alias", $slug)->first();

        return $urlData;
    }
}
