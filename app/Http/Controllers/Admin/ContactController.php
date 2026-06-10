<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('user')->latest()->paginate(10);

        $settings = [
            'contact_address'     => Setting::get('contact_address', 'Komplek Perkantoran Bukit Cinto Kenang, Sengeti, Kabupaten Muaro Jambi, Jambi 36381'),
            'contact_phone_ext'   => Setting::get('contact_phone_ext', '(0741) 123456'),
            'contact_email'       => Setting::get('contact_email', 'kontak@dtph-muarojambi.go.id'),
            'contact_hours'       => Setting::get('contact_hours', 'Senin — Jumat'),
            'contact_hours_time'  => Setting::get('contact_hours_time', '08.00 - 16.00 WIB'),
            'social_whatsapp'     => Setting::get('social_whatsapp', '+62 812-3456-7890'),
            'social_facebook'     => Setting::get('social_facebook', ''),
            'social_instagram'    => Setting::get('social_instagram', ''),
            'social_twitter'      => Setting::get('social_twitter', ''),
            'maps_embed_url'      => Setting::get('maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15951.353427506246!2d103.4883499!3d-1.2520866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e25786f02172777%3A0xc07842c1694f4c28!2sDinas%20Tanaman%20Pangan%20Dan%20Hortikultura%20Kabupaten%20Muaro%20Jambi!5e0!3m2!1sid!2sid!4v1714570000000!5m2!1sid!2sid'),
        ];

        return view('admin.contacts.index', compact('contacts', 'settings'));
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
            'status'        => 'replied',
            'reply_message' => $validated['reply_message'],
            'replied_at'    => now(),
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Balasan pesan berhasil dikirim ke Pusat Pesan pengguna.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'contact_address'    => 'required|string|max:500',
            'contact_phone_ext'  => 'nullable|string|max:50',
            'contact_email'      => 'required|email|max:255',
            'contact_hours'      => 'required|string|max:100',
            'contact_hours_time' => 'required|string|max:100',
            'social_whatsapp'    => 'nullable|string|max:50',
            'social_facebook'    => 'nullable|url|max:255',
            'social_instagram'   => 'nullable|url|max:255',
            'social_twitter'     => 'nullable|url|max:255',
            'maps_embed_url'     => 'nullable|url|max:1000',
        ]);

        $keys = [
            'contact_address', 'contact_phone_ext', 'contact_email', 
            'contact_hours', 'contact_hours_time', 'social_whatsapp', 'social_facebook', 'social_instagram', 
            'social_twitter', 'maps_embed_url'
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()->route('admin.contacts.index')->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}
