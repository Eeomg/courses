<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    public function update(Request $request, Contact $contact)
    {
        try {
            $request->validate([
                'value' => 'required|string|max:255',
            ]);

            $contact->update([
                'value' => $request['value'],
            ]);
            Alert::success('success', 'Partner updated successfully');
            return redirect()->route('contacts.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong']);
        }
    }

}
