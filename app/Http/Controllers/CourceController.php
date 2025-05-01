<?php

namespace App\Http\Controllers;

use App\Models\Cource;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourceController extends Controller
{
    
    public function addCource(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'required|string',
            'category' => 'required|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:51200',//50mb
            'pdf' => 'nullable|file|mimes:pdf|max:20480',//20mb
        ]);

        $videoUrl = $request->hasFile('video')
            ? Cloudinary::upload($request->file('video')->getRealPath(), ['resource_type' => 'video'])->getSecurePath()
            : null;

        $pdfUrl = $request->hasFile('pdf')
            ? Cloudinary::upload($request->file('pdf')->getRealPath(), ['resource_type' => 'raw'])->getSecurePath()
            : null;

        $cource = Cource::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor' => $request->instructor,
            'category' => $request->category,
            'video_url' => $videoUrl,
            'pdf_url' => $pdfUrl,
        ]);

        return response()->json(['message' => 'Cource created successfully', 'cource' => $cource], 201);
    }

    public function getInstructoreCources(Request $request)
    {
        $request->validate([
            'instructor' => 'required|string'
        ]);

        $cources = Cource::where('instructor', $request->user)->get();

        return response()->json(['cources' => $cources]);
    }

    public function getCource(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:cources,id'
        ]);

        $cource = Cource::findOrFail($request->id);

        return response()->json(['cource' => $cource]);
    }
    public function getAllCources(Request $request){

        $courses = Cource::all();
        return response()->json(["coucres" => $courses]);
    }
}
