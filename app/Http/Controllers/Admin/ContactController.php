<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        return view('admin.contact.index', compact('contact'));
    }

    public function edit()
    {
        $contact = Contact::firstOrNew();
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email'       => 'required|email',
            'telepon'     => 'required|string|max:50',
            'alamat'      => 'required|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'link_maps'   => 'nullable|url',
            'url_email'   => 'nullable|string',
            'url_telepon' => 'nullable|string',
            'url_alamat'  => 'nullable|string',

            'social_facebook'  => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok'    => 'nullable|url|max:255',
            'social_x'         => 'nullable|url|max:255',
        ]);

        // Jika link_maps kosong & koordinat ada → bentuk embed GMaps otomatis
        if (empty($validated['link_maps']) && !empty($validated['latitude']) && !empty($validated['longitude'])) {
            $lat = $validated['latitude'];
            $lng = $validated['longitude'];
            $validated['link_maps'] = "https://www.google.com/maps?q={$lat},{$lng}&z=16&hl=id&output=embed";
        }

        $contact = Contact::first();
        if ($contact) {
            $contact->update($validated);
        } else {
            Contact::create($validated);
        }
        Cache::forget('footer_contact');
        Cache::forget('footer_contact_v2');

        return redirect()->route('admin.contact.index')->with('success', 'Kontak berhasil diperbarui.');
    }
}
