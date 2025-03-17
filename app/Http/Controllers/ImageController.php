<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var Images[] $images
         *               this returns all the images but in formate as array
         */
        return Images::all()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => url(Storage::url($image->path)),
                    'label' => $image->label,
                ];
            });
    }

    /**
     * store the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['nullable', 'string ', 'min:3', 'max:255', 'unique:images'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $path = $request->file('image')->store('images', 'public');

        return Images::create($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Images $images)
    {
        //
    }
}
