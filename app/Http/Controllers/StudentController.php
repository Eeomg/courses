<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::when(request()->query('name'),function ($query,$value){
            $query->where('name',$value);
        })->paginate();
        return view('students.index', compact('students'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|min:8|string',
            ]);
            $student = Student::findOrFail($id);
            $student->update(['password'=> Hash::make($request->password)]);
            Alert::success('success','updated successfully');
            return redirect()->route('students.index')->with('success', 'password updated successfully');
        }catch (\Exception $exception){
            return redirect()->route('students.index')->with('error', 'try again');
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:students,id',
                'action' => 'required|in:delete,toggle_activation',
            ]);

            $students = Student::whereIn('id', $request->ids);

            if ($request->action === 'delete') {
                $students->delete();
                Alert::success("Success", "Students deleted successfully");
            } elseif ($request->action === 'toggle_activation') {
                $students->get()->each(
                    fn($student) => $student->update([
                        'active' => !$student->active,
                    ])
                );

                Alert::success("Success", "Students' activation status updated");
            }

            return redirect()->route('students.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
