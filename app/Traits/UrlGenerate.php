<?php
namespace App\Traits;
use Illuminate\Support\Str;
use App\Models\ShortenLink;

trait UrlGenerate
{
    function makeUniqueShortLink(){
        
        $url = Str::random(8);
        $existsInShortLinks = ShortenLink::where('url', $url)->exists();

        while($existsInShortLinks){
            $url= Str::random(8);
        }
        return $url;
    }
}