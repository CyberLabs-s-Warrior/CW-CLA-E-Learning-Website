<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactClientController extends Controller
{
    public function index()
    {
        // ambil record tunggal kontak
        $contact = Contact::first();

        // bentuk URL embed gmaps untuk view publik (prioritas link_maps; fallback lat/lng)
        $gmapsEmbed = null;
        if (!empty($contact?->link_maps)) {
            $gmapsEmbed = str_contains($contact->link_maps, 'output=embed')
                ? $contact->link_maps
                : $contact->link_maps . (str_contains($contact->link_maps, '?') ? '&' : '?') . 'output=embed';
        } elseif (!empty($contact?->latitude) && !empty($contact?->longitude)) {
            $gmapsEmbed = 'https://www.google.com/maps?q=' . $contact->latitude . ',' . $contact->longitude . '&z=16&hl=id&output=embed';
        }

        // URL klik (non-embed) untuk tombol "Buka di Google Maps"
        $gmapsClick = null;
        if (!empty($contact?->alamat)) {
            $gmapsClick = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($contact->alamat);
        } elseif (!empty($contact?->latitude) && !empty($contact?->longitude)) {
            $gmapsClick = 'https://www.google.com/maps?q=' . $contact->latitude . ',' . $contact->longitude;
        }

        return view('guest.contact.index', compact('contact', 'gmapsEmbed', 'gmapsClick'));
    }
}
