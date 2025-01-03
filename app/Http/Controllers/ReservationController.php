<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Display a listing of the resource.
     */
    public function allReservations(Request $request) {
        $username = $request->username ?? null;
        $status = $request->status ?? null;
        $payment_status = $request->payment_status ?? null;
        $date_ini = $request->date_ini ?? null;
        $date_end = $request->date_end ?? null;
        $reservationsQuery = Reservation::with('user')->latest();
        if ($username) {
            $reservationsQuery->whereHas('user', function ($query) use ($username) {
                $query->where('name', 'like', "%$username%");
            });
        }
        if ($status) {
            $reservationsQuery->where('status', "$status");
        }
        if ($payment_status) {
            $reservationsQuery->where('payment_status', "$payment_status");
        }

        if ($date_ini) {
            $reservationsQuery->where('start_date', '>=', "$date_ini");
        }

        if ($date_end) {
            $reservationsQuery->where('end_date', '<=', "$date_end");
        }

        $reservations = $reservationsQuery->paginate(15);
        return view('admin.reservations.list', compact('reservations', 'username', 'status', 'payment_status', 'date_ini', 'date_end'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($car_id)
    {
        $user = auth()->user();
        $car = Car::find($car_id);
        return view('reservation.create', compact('car', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $car_id)
    {
        // dd($request->all());
        $request->validate([
            'full-name' => 'required|string|max:255',
            'email' => 'required|email',
            'reservation_dates' => 'required',
        ]);


        $car = Car::find($car_id);
        $user = Auth::user();

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        // Check if the user has more than 2 reservations
        // $userReservationsCount = Reservation::where('user_id', $user->id)->count();

        //campo que limita no maximo 2 reservas
        // if ($userReservationsCount >= 2) {
        //     return redirect()->back()->with('error', 'You cannot have more than 2 active reservations 😉.');
        // }

        // extract start and end date from the request
        $reservation_dates = explode(' to ', $request->reservation_dates);
        $start = Carbon::parse($reservation_dates[0]);
        $end = Carbon::parse($reservation_dates[1]);

        $reservation = new Reservation();
        $reservation->user()->associate($user);
        $reservation->car()->associate($car);
        $reservation->start_date = $start;
        $reservation->end_date = $end;
        $reservation->days = $start->diffInDays($end);
        $reservation->price_per_day = $car->price_per_day;
        $reservation->total_price = $reservation->days * $reservation->price_per_day;
        $reservation->status = 'Pending';
        $reservation->payment_method = 'At store';
        $reservation->payment_status = 'Pending';
        $reservation->save();

        $car->status = 'Reserved';
        $car->save();

        return view('thankyou', ['reservation' => $reservation]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($reservation_id)
    {
        $user = auth()->user();
        $reservation = Reservation::find($reservation_id);
        $car = Car::find($reservation->car_id);
        return view('reservation.edit', compact('car', 'user', 'reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        $reservation_dates = explode(' to ', $request->reservation_dates);
        $start = Carbon::parse($reservation_dates[0]);
        $end = Carbon::parse($reservation_dates[1]);
        $car = Car::find($reservation->car_id);
        $reservation->start_date = $start;
        $reservation->end_date = $end;
        $reservation->days = $start->diffInDays($end);
        $reservation->price_per_day = $car->price_per_day;
        $reservation->total_price = $reservation->days * $reservation->price_per_day;
        $reservation->status = 'Pending';
        $reservation->payment_method = 'At store';
        $reservation->payment_status = 'Pending';
        $reservation->save();
        return view('thankyou', ['reservation' => $reservation]);
    }

    // Edit and Update Payment status
    public function editPayment(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updatePayment', compact('reservation'));
    }

    public function updatePayment(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->payment_status = $request->payment_status;
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    // Edit and Update Reservation Status
    public function editStatus(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);
        return view('admin.updateStatus', compact('reservation'));
    }

    public function updateStatus(Reservation $reservation, Request $request)
    {
        $reservation = Reservation::find($reservation->id);
        $reservation->status = $request->status;
        $car = $reservation->car;
        if ($request->status == 'Ended' || $request->status == 'Canceled') {
            $car->status = 'Available';
            $car->save();
        }
        $reservation->save();
        return redirect()->route('adminDashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
