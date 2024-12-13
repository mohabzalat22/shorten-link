<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Traits\{ApiResponse, UrlGenerate};
use App\Models\Link;
use App\Models\ShortenLink;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkController extends Controller
{
    use ApiResponse, UrlGenerate;

    public function redirect(string $shortUrl){
        try{
            $shortUrl = ShortenLink::where('url', $shortUrl)->first();
            if($shortUrl){
                $shortUrl->increment('accessCount');
                
                $redirectUrl = $shortUrl->link->url;

                if(!$redirectUrl){ return $this->errorResponse('Redirect Link error.'); }
                
                return redirect()->to($redirectUrl);
            }
        } catch(QueryException $e){
            return $this->errorResponse('Redirect Exception error.',);
        }
    }

    /**
     * Display a url of the short url.
     */
    public function getUrl(string $url)
    {
        try{
            $shortUrl = ShortenLink::where('url', $url)->first();
            if($shortUrl){
                $url = $shortUrl->link;
                return $this->successResponse('Successfuly Got The Url.', $url, 200); 
            }

            return $this->errorResponse('Error During Getting The Url.');

        } catch(QueryException $e){
            return $this->errorResponse('Get Url Exception Error.');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $validator = Validator::make($request->all(),
            [
                "user_id" => ['required'],
                "url" => ['required', 'string']
            ]
            );

        if($validator->fails()){
            return $this->errorResponse('Validation error.', $validator->errors());
        }

        try{
            //exists
            $linkAlreadyExists = Link::where('url', $request->url)->exists();

            if(!$linkAlreadyExists){
                // create new link if not exists
                $link = Link::create([
                    'user_id' => $request->user_id,
                    'url' => $request->url
                ]);

                if(!$link){ return $this->errorResponse('Error Creating Url', []); }

            }
           
            $link = Link::where('url', $request->url)->first();

            if(!$link){ return $this->errorResponse('Unable to find The Url', []); }

            $url = $this->makeUniqueShortLink();

            $shortLink = ShortenLink::create([
                'link_id' => $link->id,
                'url' => $url
            ]);

            //hide hit counts

            $shortLink->makeHidden('accessCount');

            if(!$shortLink) return $this->errorResponse('Error Occured During Creating New Short Url.', []);

            return $this->successResponse('Short url Generated Successfuly.', $shortLink, 201); 

        } catch(QueryException $e){
            return $this->errorResponse('Exception Occured During Creating New Url.', []);
        }
    }

    /**
     * Display the url stats resource.
     */
    public function getUrlStats(string $url)
    {
        try{
            $shortLink = ShortenLink::where('url', $url)->first();
            if(!$shortLink){ $this->errorResponse('Error During Getting UrlStats.', []);}
            return $this->successResponse('Successfuly Got Short Urlstats .', $shortLink, 200);
        } catch(QueryException $e){
            return $this->errorResponse('GetUrlStats Exception error.', []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $url)
    {
        try{
            $shortenLink = ShortenLink::where('url', $url)->first();

            $validator = Validator::make($request->all(),
                [
                    "url" => ['required', 'string']
                ]
                );

            if($validator->fails()){
                return $this->errorResponse('Validation error.', []);
            }

            // check if the updated record doesnot exists as short link before
            $shortLinkExists = ShortenLink::where('url', $request->url)->exists();

            if($shortLinkExists){return $this->errorResponse('Short Url Already Exists Error.', []);}

            $updatedShortLinkStatus = $shortenLink->update(
                [
                    'url' => $request->url
                ]
                );

            $updatedShortLink = ShortenLink::where('url', $request->url)->first();
            if(!$updatedShortLinkStatus) $this->errorResponse('Error During Updating Short Link.', []);
            
            // hide access count
            $updatedShortLink->makeHidden('accessCount');

            return $this->successResponse('Short Url Updated Successfuly.', $updatedShortLink, 201); 

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('ShortLink Exception error.', []);
        }
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $url)
    {
        try{
            $shortLink = ShortenLink::where('url', $url)->first();
            $shortLink->delete();
            return $this->successResponse('Short Url Deleted Successfuly.', [], 204); 

        } catch (ModelNotFoundException $e){
            return $this->errorResponse('Esception Error Occured During Deleting Short Url.', []);
        }
    }
}
