<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAboutRequest;
use App\Http\Requests\SaveContactRequest;
use App\Http\Resources\SettingsResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    private $settings;

    public function __construct()
    {
        $this->settings = Setting::find(1) ?? new Setting();
    }

    public function create(Request $request)
    {
        return Inertia::render('Settings/Create', [
            'settings' => new SettingsResource($this->settings),
        ]);
    }

    public function saveHero(Request $request)
    {
        $request->validate([
            'hero_description' => ['required', 'string'],
            'hero_image' => ['nullable', 'image'],
        ]);

        $data['hero_description'] = $request->get('hero_description');

        if ($request->file('hero_image')) {
            $this->settings->deleteImage('data->hero_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('hero_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->setOptions('public')
                ->execute();
            $data['hero_image'] = $imageName;
        }

        $this->save($data);

        return redirect()->back();
    }

    public function saveAbout(SaveAboutRequest $request)
    {

        $data['about_description'] = $request->get('about_description');

        if ($request->file('about_image')) {
            $this->settings->deleteImage('data->about_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('about_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->setOptions('public')
                ->execute();
            $data['about_image'] = $imageName;
        }

        $this->save($data);

        return redirect()->back();
    }

    public function saveContact(SaveContactRequest $request)
    {

        $data = $request->only([
            'address',
            'phone',
            'email',
            'contact_description',
            'google_map_url',
        ]);
        
        if ($request->file('contact_image')) {
            $this->settings->deleteImage('data->data->contact_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('contact_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->setOptions('public')
                ->execute();
            $data['contact_image'] = $imageName;
        }

        if ($request->file('contact_formal_image')) {
            $this->settings->deleteImage('data->contact_formal_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('contact_formal_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->setOptions('public')
                ->execute();
            $data['contact_formal_image'] = $imageName;
        }

        $this->save($data);
        return redirect()->back();
    }

    private function save(array $data): void
    {
        $this->settings->data = array_merge($this->settings->data, $data);
        $this->settings->save();
    }
}
