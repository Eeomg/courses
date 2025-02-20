<?php

namespace App\Http\Controllers;

use App\Facades\FileHandler;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::get();
        return view('payments.index', compact('payments'));
    }

    public function update(Request $request, Payment $payment)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'phone' => 'required|string',
                'description' => 'nullable|string',
                'cover' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            ]);

            $data = $request->except(['_method', '_token', 'cover']);
            if($request->hasFile('cover')){
                $data['cover'] = FileHandler::storeFile($request->cover, 'payments',$request->cover->getClientOriginalExtension());
            }

            $payment->update($data);
            Alert::success('success', 'Payment updated successfully');
            return redirect()->back();
        }catch (ValidationException $e) {
            Alert::error('error','Something went wrong: ' . $e->getMessage());
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
