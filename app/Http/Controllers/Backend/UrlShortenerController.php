<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UrlFormRequest;
use App\Contracts\UrlServiceInterface;
use App\Http\Resources\Url as UrlResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UrlShortenerController extends Controller
{
    public function __construct(UrlServiceInterface $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = $this->urlService->getUrlShorteners();
        return UrlResource::collection($urls)->additional(['success' => true ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrlFormRequest $request, UrlServiceInterface $urlService)
    {
        $url = $this->urlService->addUrlShortener(
            $request->redirect_url,
            $request->user(),
            $request->alias
        );
        return (new UrlResource($url))->additional(['success' => true ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $url = $this->urlService->getUrlShortener($id);
            return (new UrlResource($url))->additional(['success' => true ]);
        } catch (ModelNotFoundException $th) {
            return response()->json([
                "error" => "Not found for Id - $id",
                "success" => false
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UrlFormRequest $request, $id)
    {
        try {
            // We only allow to update alias or redirect_url
            // Other attribute from requests just ignore it
            $url = $this->urlService->updateUrlShortener(
                $id,
                $request->only('alias', 'redirect_url')
            );
            
            return (new UrlResource($url))->additional(['success' => true ]);
        } catch (ModelNotFoundException $th) {
            return response()->json([
                "error" => "Not found for Id - $id",
                "success" => false
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->urlService->removeUrlShortener($id);
            return response()->json(["success" => true], 200);
        } catch (ModelNotFoundException $th) {
            return response()->json([
                "error" => "Not found for Id - $id",
                "success" => false
            ], 404);
        }
    }
}
