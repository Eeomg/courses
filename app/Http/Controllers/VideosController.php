<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Video;
use App\Rules\OrderRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use RealRashid\SweetAlert\Facades\Alert;

class VideosController extends Controller
{

    /**
     * عرض نموذج إنشاء كورس جديد
     */
    public function create(string $courseId)
    {
        return view('videos.create', compact('courseId'));
    }

    /**
     * تخزين الكورس الجديد
     */
    public function store(StoreVideoRequest $request)
    {
        try {

            $validated = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'course_id' => 'required|exists:courses,id',
                'video_path' => 'required|string',
                'order' => ['required','integer',new OrderRules($request->course_id)],
                'opened' => 'nullable|boolean',
            ]);

            if($validated->fails())
            {
                FileHandler::deleteFile($request->video_path);
                return redirect()->back()->withErrors($validated)->withInput();
            }

            Video::create([
                'title' => $request->title,
                'description' => $request->description,
                'video' => $request->video_path,
                'course_id' => $request->course_id,
                'order' => $request->order,
                'opened' => $request->opened ?? false
            ]);

            Alert::success("Success", "Added successfully");
        return redirect()->route('courses.show',$request->course_id)->with('success', 'Course created successfully!');
        } catch (\Exception $exception) {
            Alert::error("Success", $exception->getMessage());
            return redirect()->back()->withErrors('error','cant add')->withInput();
        }
    }

    /**
     * عرض تفاصيل كورس معين
     */
    public function show(Course $course)
    {
        $course->load(['videos','category', 'user']);
        return view('courses.show', compact('course'));
    }

    /**
     * عرض نموذج تعديل الكورس
     */
    public function edit(string $id)
    {
        try{
            $video = Video::findOrFail($id);
            return view('videos.edit', compact('video'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error','cant edit');
        }
    }

    /**
     * تحديث بيانات الكورس
     */
    public function update(Request $request, Video $video)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'video_path' => 'required|string'
            ]);

            if($validated->fails())
            {
                FileHandler::deleteFile($request->video_path);
                return redirect()->back()->withErrors($validated)->withInput();
            }

            $video->update([
                'title' => $request->title,
                'description' => $request->description,
                'video' => $request->video_path,
            ]);

            Alert::success("Success", "Updated successfully");
            return redirect()->route('courses.show',$request->course_id);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error','cant update')->withInput();
        }
    }

    public function uploadVideo(Request $request, Course $course)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            return false;
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file

            $path = $course->category->name.'/'.$course->title;
            $fileName = FileHandler::storeFile($file,$path,$file->getClientOriginalExtension());

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('public/images/' . $fileName),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function destroy(string $id)
    {
        try {
            $video = Video::findOrFail($id);
            if(Storage::exists($video->video)){
                FileHandler::deleteFile($video->video);
            }
            $video->delete();
            Alert::success('success', 'Course deleted successfully!');
            return redirect()->route('courses.show',$video->course_id);
        } catch (\Exception $e) {
            return redirect()->route('courses.show',$video->course_id)->with('error', 'failed to delete');
        }
    }

}
