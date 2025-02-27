<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    /**
     * عرض جميع الكورسات
     */
    public function index()
    {
        $courses = Course::with('category')
            ->withCount('videos','students')
            ->latest()->paginate(15);
        return view('courses.index', compact('courses'));
    }

    /**
     * عرض نموذج إنشاء كورس جديد
     */
    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('courses.create', compact('categories'));
    }

    /**
     * تخزين الكورس الجديد
     */
    public function store(StoreCourseRequest $request)
    {
        $cover = FileHandler::storeFile($request->cover, null, $request->cover->getClientOriginalExtension());

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'cover' => $cover,
            'user_id' => $request->user()->id,
        ]);

        Alert::success("Success", "Courses added successfully");
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * عرض تفاصيل كورس معين
     */
    public function show(Course $course)
    {
        $course->load(['videos','category', 'students','pdfs']);
        return view('courses.show', compact('course'));
    }


    public function courseStudents(Course $course)
    {
        $course->load(['category','students']);
        $students = $course->students()->paginate(15);
        return view('courses.show-students', compact('course', 'students'));
    }

    /**
     * عرض نموذج تعديل الكورس
     */
    public function edit(Course $course)
    {
        $categories = Category::select('id','name')->get();
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * تحديث بيانات الكورس
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $data = $request->validated();
            if($request->hasFile('cover')){
                $data['cover'] = FileHandler::updateFile($request->cover,$course->cover,null,$request->cover->getClientOriginalExtension());
            }
            $course->update($data);
            return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('courses.update',$course->id)->with('error', $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:courses,id',
                'action' => 'required|in:delete,toggle_activation',
            ]);

            $course = Course::whereIn('id', $request->ids);

            if ($request->action === 'delete') {
                $course->get()->each(
                    fn($course) => FileHandler::deleteFile($course->cover)
                );
                $course->delete();
                Alert::success("Success", "Users deleted successfully");
            } elseif ($request->action === 'toggle_activation') {
                $status = [
                    'active' => 'inactive',
                    'inactive' => 'active',
                ];
                $course->get()->each(
                    fn($course) => $course->update([
                        'status' => $status[$course->status]
                    ])
                );

                Alert::success("Success", "Courses' activation status updated");
            }

            return redirect()->route('courses.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function courseStudentsBulkAction(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:students,id',
                'action' => 'required|in:delete',
                'course_id' => 'required|integer|exists:courses,id',
            ]);

            $course = Course::findOrFail($request->course_id);
            $students = Student::whereIn('id', $request->ids)->get();

            if ($request->action === 'delete') {
                $course->students()->detach($students->pluck('id'));
                Alert::success("Success", "Students removed from the course successfully.");
            }

            return redirect()->route('course-students.show', $request->course_id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


}
