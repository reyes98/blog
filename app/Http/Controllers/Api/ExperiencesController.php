<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperiencesController extends Controller
{
    public function index(Request $request)
    {
        $experiences =  Experience::with(['category:id,name'])->latest()
            ->simplePaginate($request->get('limit', 6));
        return ExperienceResource::collection($experiences);
    }

    public function show(Request $request, Experience $experience)
    {
        $experience->load(['category:id,name']);
        return new ExperienceResource($experience);
    }
}
