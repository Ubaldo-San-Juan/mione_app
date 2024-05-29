<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResources;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VideoCollection::make(Video::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'data.attributes.title' => ['required', 'min:4'],
            'data.attributes.description' => ['required'],
            'data.attributes.slug' => ['required'],
            'data.attributes.user_id' => ['required', 'integer'],
            'data.attributes.category_id' => ['required', 'integer']
           ]);
    
           $video = Video::create([
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'slug' => $request->input('data.attributes.slug'),
            'user_id' => $request->input('data.attributes.user_id'),
            'category_id' => $request->input('data.attributes.category_id'),
           ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return new VideoResources($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::find($id);
        
        if (!$video) {
            return response()->json(['message' => 'Video no encontrado'], 404);
        }
    
        if ($request->isMethod('patch')) {
            $request->validate([
                'data.attributes.title' => ['sometimes', 'required', 'min:4'],
                'data.attributes.description' => ['sometimes', 'required'],
                'data.attributes.slug' => ['sometimes', 'required'],
                'data.attributes.user_id' => ['sometimes','required', 'integer'],
                'data.attributes.category_id' => ['sometimes','required', 'integer']
            ]);
    
            if ($request->filled('data.attributes.title')) {
                $video->title = $request->input('data.attributes.title');
            }
    
            if ($request->filled('data.attributes.description')) {
                $video->description = $request->input('data.attributes.description');
            }
    
            if ($request->filled('data.attributes.slug')) {
                $video->slug = $request->input('data.attributes.slug');
            }

            if ($request->filled('data.attributes.user_id')) {
                $video->slug = $request->input('data.attributes.user_id');
            }

            if ($request->filled('data.attributes.category_id')) {
                $video->slug = $request->input('data.attributes.category_id');
            }
    
    
            $video->save();
    
        } else if ($request->isMethod('put')) {
            $request->validate([
                'data.attributes.title' => ['required', 'min:4'],
                'data.attributes.description' => ['required'],
                'data.attributes.slug' => ['required'],
                'data.attributes.user_id' => ['required', 'integer'],
                'data.attributes.category_id' => ['required', 'integer']
            ]);
    
            $video->update([
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'slug' => $request->input('data.attributes.slug'),
                'user_id' => $request->input('data.attributes.user_id'),
                'category_id' => $request->input('data.attributes.category_id'),
            ]);
        }
    
        // Devuelve una respuesta JSON con el video actualizado
        return response()->json([
            'message' => 'Actualización exitosa',
            'video' => new VideoResources($video)
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video ->delete();
        return response()->json(null, 204);
    }
}
