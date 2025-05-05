<?php

namespace App\Http\Controllers;

use App\Models\Cource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cloudinary\Cloudinary; 
use Illuminate\Support\Facades\Log;

class CourceController extends Controller
{
  
    public function addCource(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string',
        'instructor_id' => 'required|exists:users,id',
        'videos.*' => 'nullable|file|mimes:mp4,mov,avi|max:51200', // max:50MB
        'pdfs.*' => 'nullable|file|mimes:pdf|max:20480', // max:20MB
    ]);

    $videoUrls = [];
    $videos = $request->file('videos');

    if ($videos) {
        $videos = is_array($videos) ? $videos : [$videos];

        foreach ($videos as $video) {
            $realPath = $video->getRealPath();
            Log::info("Uploading video from path: {$realPath}");

            $cloudinary = new Cloudinary();
            $uploadResult = $cloudinary->uploadApi()->upload($realPath, [
                'resource_type' => 'video'
            ]);

            $videoUrls[] = $uploadResult['secure_url'];
        }
    }

    $pdfUrls = [];
    $pdfs = $request->file('pdfs');

    if ($pdfs) {
        $pdfs = is_array($pdfs) ? $pdfs : [$pdfs];

        foreach ($pdfs as $pdf) {
            $realPath = $pdf->getRealPath();
            Log::info("Uploading PDF from path: {$realPath}");
            $cloudinary = new Cloudinary();
            $uploadResult = $cloudinary->uploadApi()->upload($realPath, [
                'resource_type' => 'raw'
            ]);


            $pdfUrls[] = $uploadResult['secure_url'];
        }
    }

    $course = Cource::create([
        'title' => $request->title,
        'description' => $request->description,
        'slug' => Str::slug($request->title) . '-' . uniqid(),
        'category' => $request->category,
        'instructor_id' => $request->instructor_id,
        'videos' => $videoUrls,
        'pdfs' => $pdfUrls,
    ]);

    return response()->json([
        'message' => 'Course created successfully',
        'course' => $course,
    ], 201);
}


    
    

    public function getInstructorCourses(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
        ]);

        $courses = Cource::where('instructor_id', $request->instructor_id)->get();

        return response()->json(['courses' => $courses]);
    }

    public function getCource(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:cources,id'
        ]);

        $course = Cource::findOrFail($request->id);

        return response()->json(['course' => $course]);
    }

    public function getAllCources()
    {
        $courses = Cource::all();
        return response()->json(['courses' => $courses]);
    }
}
