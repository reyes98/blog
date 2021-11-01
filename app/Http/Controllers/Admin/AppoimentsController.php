<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppoimentsResource;
use App\Models\Appoiment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppoimentsController extends Controller
{
    public function index(Request $request)
    {
        // $query->whereBetween('date', array($from, $to));
        $query = Appoiment::query();
        if (request('search')) {            
            $query->where(function ($subQuery) {
                $subQuery->where('name', 'LIKE', '%' . request('search') . '%')
                      ->orWhere('email', 'LIKE', '%' . request('search') . '%');
            });
        }

        
        $query->where('status', '=', request('status')?request('status'):'pending');
        

        $appoiments = $query->latest()->simplePaginate(10);
        return Inertia::render('Appoiments/Index', [
            'appoiments' => AppoimentsResource::collection($appoiments),
            'selectOptions' =>  [
                1 => 'Pending',
                2 => 'Confirmed',
                3 => 'Finished',
                4 => 'Canceled',
            ],
            'filters' => [
                'search' => request('search'),
                'status' => request('status'),
            ],
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Appoiments/Create', [
            'edit' => false,
            'appoiment' => (object) [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            // 'start_time' => ['required', 'date'],
            'message' => ['required', 'string', 'max:200'],
        ]);

        if ($request->has('start_time')) {
            $data['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        }

        // $data['status'] = 'pending';

        // Mail::to('guapacha2@hotmail.com')->send(new SentApoimentMail($data));

        Appoiment::create($data);

        return redirect()->route('appoiments.index')->with('success', 'Appoiment saved succesfully');
    }

    public function edit(Appoiment $appoiment)
    {
        return Inertia::render('Appoiments/Create', [
            'edit' => true,
            'appoiment' => new AppoimentsResource($appoiment),
        ]);
    }

    public function updateSatus(Request $request)
    {
        $appoiment = Appoiment::find($request->id);
        $appoiment->status = $request->status;
        $appoiment->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function update(Request $request, Appoiment $appoiment)
    {
        $data = $request->validate([
            'status' => ['required'],
        ]);

        $appoiment->update($data);


        return redirect()->route('appoiments.index')->with('success', 'Appoiment edited succesfully');
    }

    public function destroy(Appoiment $appoiment)
    {
        $appoiment->delete();
        return redirect()->route('appoiments.index')->with('success', 'Appoiment deleted succesfully');
    }
}