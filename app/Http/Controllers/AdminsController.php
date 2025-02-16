<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'nullable|string|unique:users',
                'password' => 'required|string|min:6',
                'roles' => 'required|array',
            ]);

            // إضافة التحقق والتفعيل
            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['email_verified_at'] = now();
            $validatedData['activated'] = true;

            $user = User::create($validatedData);

            if (!empty($validatedData['roles'])) {
                $user->syncRoles($validatedData['roles']);
            }

            Alert::success("Success", "User successfully added");
            return redirect()->route('admins.index');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'roles' => 'array',
            ]);

            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            Alert::success("Success", "User updated successfully");
            return redirect()->route('admins.index');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:users,id',
                'action' => 'required|in:delete,toggle_activation',
            ]);

            $users = User::whereIn('id', $request->ids);

            if ($request->action === 'delete') {
                $users->delete();
                Alert::success("Success", "Users deleted successfully");
            } elseif ($request->action === 'toggle_activation') {
                foreach ($users->get() as $user) {
                    $user->update(['activated' => !$user->activated]);
                }
                Alert::success("Success", "Users' activation status updated");
            }

            return redirect()->route('admins.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
