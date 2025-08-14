<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    // Main page दिखाने के लिए
    public function index()
    {
        return view('welcome');
    }

    // URL shorten करने के लिए  
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'url' => 'required|url|max:2048'
        ]);

        $originalUrl = $request->input('url');
        
        // Check करो कि URL already exists या नहीं
        $existingUrl = Url::where('original_url', $originalUrl)->first();
        
        if ($existingUrl) {
            return response()->json([
                'success' => true,
                'shortened_url' => $existingUrl->shortened_url,
                'existing' => true
            ]);
        }

        // नया short URL बनाओ
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

    // Redirect करने के लिए
    public function redirect($shortCode)
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url) {
            abort(404, 'URL not found');
        }

        // Click count बढ़ाओ
        $url->increment('clicks');

        return redirect($url->original_url);
    }
}