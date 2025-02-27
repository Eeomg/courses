<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Http\Requests\StorePdfRequest;
use App\Http\Requests\UpdatePdfRequest;
use App\Models\Pdf;
use App\Models\Video;
use Illuminate\Support\Facades\Response;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class PdfController extends Controller
{

    public function create(string $courseId)
    {
        try {
            $videos = Video::where('course_id', $courseId)->get();
            return view('pdfs.create', compact('courseId','videos'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('course not found');
        }
    }

    public function edit(Pdf $pdf)
    {
        try {
            $videos = Video::where('course_id', $pdf->course_id)->get();
            return view('pdfs.edit', compact('pdf','videos'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('course not found');
        }
    }


    public function store(StorePdfRequest $request)
    {
        try {

            $file = FileHandler::storeFile($request->file, 'pdfs',$request->file->getClientOriginalExtension());

            Pdf::create([
                'title' => $request->title,
                'description' => $request->description,
                'file' => $file,
                'course_id' => $request->course_id,
                'video_id' => $request->video_id,
            ]);

            Alert::success("Success", "Added successfully");
            return redirect()->route('courses.show',$request->course_id);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error','cant add')->withInput();
        }
    }

    public function update(UpdatePdfRequest $request,Pdf $pdf)
    {
        try {
            $file = $pdf->file;
            if($request->hasFile('file')){
                $file = FileHandler::storeFile($request->file, $file,  'pdfs',$request->file->getClientOriginalExtension());
            }

            $pdf->update([
                'title' => $request->title,
                'description' => $request->description,
                'file' => $file,
                'video_id' => $request->video_id,
            ]);

            Alert::success("Success", "Update successfully");
            return redirect()->route('courses.show',$pdf->course_id);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error','cant add')->withInput();
        }
    }


    public function destroy(Pdf $pdf)
    {
        try {
            FileHandler::deleteFile($pdf->file);
            $pdf->delete();
            Alert::success("Success", "Deleted successfully");
            return redirect()->route('courses.show',$pdf->course_id);
        } catch (Exception $exception) {
            return redirect()->back()->withErrors('error','cant delete');
        }
    }
}
