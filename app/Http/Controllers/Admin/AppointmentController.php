<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Appointments = Appointment::query()
        // ->with('clients:client_id, first_name, last_name')
        // ->join('clients', 'clients.id', '=' , 'appointments.client_id')
        ->when(request('status'), function($query){ 
            return $query->where('status', AppointmentStatus::from(request('status')));
        })
        ->latest()
        ->paginate();
        return $Appointments;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required', 
        ]);

         Appointment::create([
            'client_id' => 1,
            'title' => request('title'),
            'description' => request('description'),
            'start_time' => now(),
            'end_time' => now(),
            'status' => 1,
        ]);

        return response()->json(['message' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
