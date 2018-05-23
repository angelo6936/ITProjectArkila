<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Destination;
use App\ReservationDate;
use App\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerReservationRequest;
use Session;
use Carbon\Carbon;
use App\Ticket;
use PDF;

class MakeReservationController extends Controller
{
    public function __construct()
    {
      $this->middleware('online-reservation');
    }
    public function createReservation()
    {
		$destinations = Destination::allRoute()->orderBy('destination_name')->get();
    	return view('customermodule.user.reservation.selectDestination', compact('destinations'));
	}
	
	public function showDetails(Request $request)
	{
		$destination = $request->destination;
		if($destination == null)
		{
			return back();
		}
		else
		{
			Session::put('key', $destination);	
			return redirect('/home/reservation/show-reservations');
		}
	}
	public function reservationCreate(ReservationDate $reservation)
	{
		$main = Destination::mainTerminal()->get()->first();
		$requested = Session::get('key');
		$dropOff = Destination::where('destination_id', $requested)->get()->first();
		return view('customermodule.user.reservation.createReservation', compact('reservation', 'main', 'dropOff'));
	}

	public function showDate(Request $request)
	{
		if($request->submit == 'Update')
		{
			$destination = $request->destination;
			$getDestination = Session::put('key', $destination);
			$destination = Destination::where('destination_id', $getDestination)->get();
			$destinations = Destination::allRoute()->orderBy('destination_name')->get();
			$reservations = ReservationDate::all();
	
			return redirect('/home/reservation/show-reservations');

		}
		else
		{
			$getDestination = Session::get('key');
			$destination = Destination::where('destination_id', $getDestination)->get();
			$destinations = Destination::allRoute()->orderBy('destination_name')->get();
			$reservations = ReservationDate::all();
	
			return view('customermodule.user.reservation.selectReservationDate', compact('destinations','destination', 'reservations', 'getDestination'));
		}
	}

	public function storeRequest(Request $request, ReservationDate $reservation)
	{
		$expiry = Carbon::now()->addDays(2);
		$slot = $reservation->number_of_slots;
		$quantity = $request->quantity;
		if($quantity <= $slot)
		{
			$newSlot = $reservation->number_of_slots - $request->quantity;
			$destination = Destination::where('destination_id', Session::get('key'))->get()->first();
			$ticket = Ticket::where('destination_id', $destination->destination_id)->get()->first();
			$toBePaid = $ticket->fare * $quantity;
	

			$codes = Reservation::all();
			$newCode = bin2hex(openssl_random_pseudo_bytes(8));
			foreach ($codes as $code)
			{
				$allCodes = $code->rsrv_code;

				do
				{
					$newCode =  bin2hex(openssl_random_pseudo_bytes(8));

				} while ($newCode == $allCodes);
			}
			$this->validate(request(), [
				'contactNumber' => 'bail|numeric|required',
				'quantity' => 'bail|numeric|required|min:1|max:2',
			]);
			$transaction = Reservation::create([
				'user_id' => auth()->user()->id,
				'date_id' => $reservation->id,
				'destination_name' => $destination->destination_name,
				'rsrv_code' => $newCode,
				'name' => auth()->user()->full_name,
				'contact_number' => $request->contactNumber,
				'ticket_quantity' => $quantity,
				'fare' => $toBePaid,
				'expiry_date' => $expiry,
				'type' => 'Online',
			]);

			$reservation->update([
				'number_of_slots' => $newSlot,
			]);

		    return redirect(route('customermodule.success', $transaction->id))->with('success', 'Successfully created a reservation.');

	
		}
		else
		{
			return back()->withErrors('There are not enough slots for '.$quantity.' persons.');
		}
	}

	public function reservationSuccess(Reservation $transaction)
	{
		return view('customermodule.user.reservation.success', compact('transaction'));
	}

	public function reservationTransaction()
	{
		$requests = Reservation::where('user_id', auth()->user()->id)->get();
		$a = Carbon::parse($requests->first()->expiry_date);
		$b = Carbon::now();

		return view('customermodule.user.transactions.customerReservation', compact('requests'));
	}

	public function rentalTransaction()
	{
		$reservations = Reservation::all();
		$requests = Reservation::where('user_id', auth()->user()->id)->count();

		return view('customermodule.user.transactions.customerRental', compact('reservations', 'requests'));
	}

	public function reservationPdf(Reservation $reservation)
	{
		$date = Carbon::now();
        $pdf = PDF::loadView('pdf.reservationPdf', compact('reservation', 'date'));
		return $pdf->stream("Receipt No. ". $reservation->rsrv_code .".pdf");
	}

	public function fareList()
	{
		$destinations = Destination::allTerminal()->get();
		return view('customermodule.fareList', compact('destinations'));
	}
}
