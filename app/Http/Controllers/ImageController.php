<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'images' => Images::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'lable' => ['required', 'string', 'max:255', 'min:3'],
        ]);

        $image = Images::create($data);

        return response()->json([
            'message' => 'Image created successfully',
            'image' => $image,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Images $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Images $images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Images $images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Images $images)
    {
        //
    }
}
