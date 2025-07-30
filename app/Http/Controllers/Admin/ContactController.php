<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();

        return view('admin.contact.index', compact('contact'));
    }

    public function edit()
    {
        $contact = Contact::firstOrNew(); // Buat instance baru kalau belum ada
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'location_label' => 'required|string|max:100',
            'location_url' => 'required|url',
        ]);

        $contact = Contact::first();

        if ($contact) {
            $contact->update($validated);
        } else {
            Contact::create($validated);
        }

        return redirect()->route('admin.contact.index')->with('success', 'Kontak berhasil diperbarui.');
    }

}
