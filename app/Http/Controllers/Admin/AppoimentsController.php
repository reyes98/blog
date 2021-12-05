<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppoimentsResource;
use App\Mail\SentAppoimentMail;
use App\Models\Appoiment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use IntlChar;

use function Psy\info;

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
            'statusOptions' =>  [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'finished' => 'Finished',
                'canceled' => 'Canceled',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:200'],
            'price' => ['required', 'numeric'],
        ]);

        if ($request->has('start_time')) {
            $data['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        }

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        Mail::to('danielitado@hotmail.com')->send(new SentAppoimentMail($data));

        Appoiment::create($data);

        return redirect()->route('appoiments.index')->with('success', 'Appoiment created succesfully');
    }

    public function edit(Appoiment $appoiment)
    {
        return Inertia::render('Appoiments/Create', [
            'edit' => true,
            'appoiment' => new AppoimentsResource($appoiment),
            'statusOptions' =>  [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'finished' => 'Finished',
                'canceled' => 'Canceled',
            ],
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
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:200'],
            'price' => ['required', 'numeric'],
        ]);

        if ($request->has('start_time')) {
            $data['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        }

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        $appoiment->update($data);


        return redirect()->route('appoiments.index')->with('success', 'Appoiment edited succesfully');
    }

    public function destroy(Appoiment $appoiment)
    {
        $appoiment->delete();
        return redirect()->route('appoiments.index')->with('success', 'Appoiment deleted succesfully');
    }
}
