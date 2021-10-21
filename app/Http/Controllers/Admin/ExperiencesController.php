<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExperienceResource;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ExperiencesController extends Controller
{
    public function index(Request $request)
    {
        $experience = Experience::with(['category:id,name'])->latest()->simplePaginate(10);
        return Inertia::render('Experiences/Index', [
            'experiences' => ExperienceResource::collection($experience),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Experiences/Create', [
            'edit' => false,
            'experience' => new ExperienceResource(new Experience),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function store(Request $request, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Experience::class)],
            'image' => ['required', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $uploadFile->setFile($request->file('image'))
            ->setUploadPath((new Experience())->uploadFolder())
            ->setOptions('public')
            ->execute();

        Experience::create($data);

        return redirect()->route('experiences.index')->with('success', 'Experience saved successfully.');
    }

    public function destroy(Experience $experience)
    {
        $experience->deleteImage();
        $experience->delete();
        return redirect()->route('experiences.index')->with('success', 'Experience deleted succesfully');
    }

    public function edit(Experience $experience)
    {
        return Inertia::render('Experiences/Create', [
            'edit' => true,
            'experience' => new ExperienceResource($experience),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function update(Request $request, Experience $experience, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Experience::class)->ignore($experience->id)],
            'image' => ['nullable', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $experience->image;
        if ($request->file('image')) {
            $experience->deleteImage();

            $data['image'] = $uploadFile->setFile($request->file('image'))
                ->setUploadPath($experience->uploadFolder())
                ->setOptions('public')
                ->execute();
        }

        $experience->update($data);

        return redirect()->route('experiences.index')->with('success', 'Experience updated successfully.');
    }
}
