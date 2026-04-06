<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Storage;

class HomepageSettingController extends Controller
{
    /**
     * Show homepage settings form
     */
    public function index()
    {
        $settings = HomepageSetting::getSettings();
        return view('admin.homepage-settings', compact('settings'));
    }

    /**
     * Update homepage settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'academic_year' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_ppdb_open' => 'boolean',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
        ]);

        $settings = HomepageSetting::first();
        
        if (!$settings) {
            $settings = new HomepageSetting();
        }

        $data = $request->except(['logo', 'hero_image', 'about_image']);
        $data['is_ppdb_open'] = $request->boolean('is_ppdb_open');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Delete old hero image
            if ($settings->hero_image) {
                Storage::disk('public')->delete($settings->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('hero', 'public');
        }

        // Handle about image upload
        if ($request->hasFile('about_image')) {
            // Delete old about image
            if ($settings->about_image) {
                Storage::disk('public')->delete($settings->about_image);
            }
            $data['about_image'] = $request->file('about_image')->store('about', 'public');
        }

        $settings->fill($data);
        $settings->save();

        return redirect()->route('admin.homepage-settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
