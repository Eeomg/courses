<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Models\Partner;
use Illuminate\Http\Request;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return view('partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'image' => 'required|file|mimes:jpeg,png,jpg,jfif,svg|max:2048',
            ]);

            $file = $request->file('image');
            $image = FileHandler::storeFile($file, 'partner',$file->getClientOriginalExtension());

            Partner::create([
                'name' => $request['name'],
                'image' => $image,
            ]);
            Alert::success('success', 'Partner added successfully');
            return redirect()->route('partners.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong']);
        }
    }

    public function update(Request $request, Partner $partner)
    {
        try {
            $request->validate([
                'name' => 'required',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,jfif,svg|max:2048',
            ]);

            $data['name'] =$request['name'];
            if($file = $request->file('image')){
                $data['image'] = FileHandler::updateFile($file, $partner->image, 'partner',$file->getClientOriginalExtension());
            }

            $partner->update($data);

            Alert::success('success', 'Partner updated successfully');
            return redirect()->route('partners.index');
        } catch (\Exception $e) {
            dd(
                $e->getMessage()
            );
            return redirect()->back()->withErrors(['error' => 'Something went wrong']);
        }
    }


    public function destroy(Partner $partner)
    {
        try {
            FileHandler::deleteFile($partner->image);
            $partner->delete();
            Alert::success('success', 'Partner deleted successfully');
            return redirect()->route('partners.index');
        } catch (Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
