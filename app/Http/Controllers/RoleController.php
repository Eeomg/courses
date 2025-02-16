<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
                'permissions' => 'nullable|array',
            ]);

            $role = Role::create(['name' => $request->name]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            Alert::success("Success", "Role created successfully");
            return redirect()->route('roles.index');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'permissions' => 'nullable|array',
            ]);

            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name]);

            $role->syncPermissions($request->permissions ?? []);

            Alert::success("Success", "Role updated successfully");
            return redirect()->route('roles.index');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);

            if ($role->name === 'Owner') {
                return redirect()->back()->with('error', 'Cannot delete Super Admin role.');
            }

            $role->delete();

            Alert::success("Success", "Role deleted successfully");
            return redirect()->route('roles.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'role_ids' => 'required|array',
                'role_ids.*' => 'exists:roles,id',
            ]);

            Role::whereIn('id', $request->role_ids)->delete();

            Alert::success('Success', 'Selected roles have been deleted successfully');
            return redirect()->route('roles.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete roles: ' . $e->getMessage());
        }
    }


}
