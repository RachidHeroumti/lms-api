<?php

namespace App\Http\Controllers;

use App\Models\Cource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User ;
class CourceController extends Controller
{
    private $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    }

    public function addCource(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'instructor_id' => 'required|exists:users,id',
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi|max:51200',
            'pdfs.*' => 'nullable|file|mimes:pdf|max:20480',
            'thumbnail' => 'file|image',
            'duration' => 'numeric',
            'price' => 'numeric',
            'language' => 'nullable|string'
        ]);

        $videoUrls = [];

        if ($request->hasFile('videos')) {
            $videos = $request->file('videos');
            $videos = is_array($videos) ? $videos : [$videos];

            foreach ($videos as $video) {
                if ($video && is_object($video) && method_exists($video, 'getRealPath')) {
                    $realPath = $video->getRealPath();
                    $uploadResult = $this->cloudinary->uploadApi()->upload($realPath, [
                        'resource_type' => 'video'
                    ]);
                    $videoUrls[] = $uploadResult['secure_url'];
                }
            }
        }

        $pdfUrls = [];

        if ($request->hasFile('pdfs')) {
            $pdfs = $request->file('pdfs');
            $pdfs = is_array($pdfs) ? $pdfs : [$pdfs];

            foreach ($pdfs as $pdf) {
                if ($pdf && is_object($pdf) && method_exists($pdf, 'getRealPath')) {
                    $realPath = $pdf->getRealPath();
                    $uploadResult = $this->cloudinary->uploadApi()->upload($realPath, [
                        'resource_type' => 'raw'
                    ]);
                    $pdfUrls[] = $uploadResult['secure_url'];
                }
            }
        }

        $thumbnailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            if ($thumbnail && is_object($thumbnail) && method_exists($thumbnail, 'getRealPath')) {
                $realPath = $thumbnail->getRealPath();
                $uploadResult = $this->cloudinary->uploadApi()->upload($realPath, [
                    'resource_type' => 'image'
                ]);
                $thumbnailUrl = $uploadResult['secure_url'];
            }
        }

        $course = Cource::create([
             'title' => $request->title,
        'subtitle' => $request->input('subtitle'),
        'description' => $request->description,
        'slug' => $request->slug ?? Str::slug($request->title) . '-' . uniqid(),
        'category' => $request->category,
        'instructor_id' => $request->instructor_id,
        'videos' => json_encode($videoUrls),
        'pdfs' => json_encode($pdfUrls),
        'thumbnail' => $thumbnailUrl,
        'duration' => $request->input('duration'),
        'price' => $request->input('price'),
        'old_price' => $request->input('old_price'),
        'language' => $request->input('language'),
        'level' => $request->input('level', 'beginner'),
        'is_free' => $request->input('is_free', false),
        'status' => $request->input('status', 'draft'),
        'details' => $request->input('details'),
        'requirements' => $request->input('requirements'),
        'outcomes' => $request->input('outcomes'),
        'tags' => json_encode($request->input('tags')),
        'published_at' => $request->input('published_at'),
        'is_featured' => $request->input('is_featured', false),
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course,
        ], 201);
    }



  public function getInstructorCourses(Request $request, $id)
{
    $validator = Validator::make(['id' => $id], [
        'id' => 'required|integer|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid instructor ID.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $instructor = User::find($id);
    if ($instructor->role !== 'instructor'&&$instructor->role !== 'admin') {
        return response()->json([
            'message' => 'User is not an instructor.',
        ], 403);
    }

    try {
        $courses = Cource::where('instructor_id', $id)->get();

        return response()->json([
            'courses' => $courses,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to retrieve courses.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function getCource( $id)
    {
        $course = Cource::findOrFail($id);
        return response()->json(['course' => $course]);
    }

    public function getAllCources()
    {
        $courses = Cource::all();
        return response()->json(['courses' => $courses]);
    }
}
