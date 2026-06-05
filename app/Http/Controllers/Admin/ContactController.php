<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('user')->latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string',
        ]);

        $contact->update([
            'status' => 'replied',
            'reply_message' => $validated['reply_message'],
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Balasan pesan berhasil dikirim ke Pusat Pesan pengguna.');
    }
}
