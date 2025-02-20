<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Models\Setting;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request, Setting $setting)
    {

        try {
            $request->validate([
                'key' => 'required|string|in:name,logo,description,mainColor,copyRight',
                'value' => 'required',
            ]);
            $value = $request->value;
            if($request->hasFile('value')){
                $file = $request->file('value');
                $fileExtension = $file->getClientOriginalExtension();
                $value = explode('/', $setting->value);
                $old = 'setting/'.end($value);
                $name = FileHandler::updateFile($file, $old , 'setting',$fileExtension);
                $value = env('APP_IMAGES_URL').$name;
            }

            $setting->update(['value' => $value]);
            Alert::success('success','updated successfully');
            return redirect()->route('settings.index');
        }catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong please try again');
        }

    }
}
