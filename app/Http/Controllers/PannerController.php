<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Models\Panner;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class PannerController extends Controller
{
    public function index()
    {
        $banners = Panner::all();
        return view('banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'panner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $panner = FileHandler::storeFile($request->file('panner'), 'banners',$request->file('panner')->getClientOriginalExtension());

            Panner::create([
                'name' => $request->name,
                'panner' => $panner
            ]);
            Alert::success('success', 'Banner created successfully');
            return redirect()->route('banners.index');
        }catch (ValidationException $e) {
            Alert::error('error', $e->errors()[0]);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function update(Request $request, Panner $banner)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'panner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $data = [
                'name' => $request->name,
            ];
            if ($request->hasFile('panner')) {
                $data['panner'] = FileHandler::updateFile($request->file('panner'), $banner->panner, 'banners',$request->file('panner')->getClientOriginalExtension());
            }
            $banner->update($data);
            Alert::success('success', 'Banner updated successfully');
            return redirect()->route('banners.index');
        }catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong please try again');
        }
    }

    public function destroy(Panner $banner)
    {
        try {
            FileHandler::deleteFile($banner->delete());
            $banner->delete();
            Alert::success('success', 'Banner deleted successfully');
            return redirect()->route('banners.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong please try again');
        }
    }

}
