<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048'
        ]);

        $originalUrl = $request->input('url');
        
        $existingUrl = Url::where('original_url', $originalUrl)->first();
        
        if ($existingUrl) {
            return response()->json([
                'success' => true,
                'shortened_url' => $existingUrl->shortened_url,
                'existing' => true
            ]);
        }

        $url = Url::create([
            'original_url' => $originalUrl,
            'short_code' => Url::generateShortCode()
        ]);

        return response()->json([
            'success' => true,
            'shortened_url' => $url->shortened_url,
            'existing' => false
        ]);
    }

    public function redirect($shortCode)
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url) {
            abort(404, 'URL not found');
        }

        $url->increment('clicks');

        return redirect($url->original_url);
    }
}