<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Services\Helpers\RoleHelper;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::with(['customer', 'user'])->orderBy('start')->get();
        return view('appointment.index', ['appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appointment.show', ['appointment' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['customer', 'user']);
        return view('appointment.show', ['appointment' => $appointment]);
    }

    public function customer(Request $request) {
        $key = $request->query('key');

        if (!isset($key)) {
            return redirect('/')->with('errorNotification', 'Use your special link!');
        }

        $key = base64_decode($key);
        $rep;
        $reps = RoleHelper::getRepresentatives();

        foreach($reps as $theRep) {
            if (Hash::check($theRep->email, $key)) {
                $rep = $theRep;
                break;
            }
        }

        if (!isset($rep)) {
            return redirect('/')->with('errorNotification', 'Sorry, that link is invalid.');
        }

        return view('appointment.customer', ['rep' => $rep]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
