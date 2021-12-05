<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SentAppoimentMail;
use App\Models\Appoiment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppoimentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:200'],
        ]);

        if ($request->has('start_time')) {
            $data['start_time'] = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
        }
        
        $data['status'] = 'pending';
        $data['price'] = 0;
        
        Mail::to('danielitado@hotmail.com')->send(new SentAppoimentMail($data));

        Appoiment::create($data);

        return response()->json([
            'message' => 'Your appoiment has been booked successfully!',
        ]);
    }
}
