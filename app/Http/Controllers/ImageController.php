<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = Images::all()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => url(Storage::url($image->path)),
                'label' => $image->label,
            ];
        });

        return response()->json($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['nullable', 'string', 'min:3', 'max:255', 'unique:images'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $path = $request->file('image')->store('images', 'public');

        $image = Images::create([
            'label' => $data['label'],
            'path' => $path,
        ]);

        return response()->json($image, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Images $images)
    {
        Storage::disk('public')->delete($images->path);
        $images->delete();

        return response()->noContent();
    }
}
