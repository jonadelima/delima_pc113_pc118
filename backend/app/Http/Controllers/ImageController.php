<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public'); // Save to 'storage/app/public/uploads'
            return response()->json([
                'message' => 'Image uploaded successfully',
                'path' => $path,
            ], 201);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
}
