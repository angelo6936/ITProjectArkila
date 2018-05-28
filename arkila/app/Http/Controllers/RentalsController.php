<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VanRental;
use Carbon\Carbon;
use App\BookingRules;
use App\Destination;
use App\Van;
use App\Member;
use App\Rules\checkTime;
use App\Http\Requests\RentalRequest;
use Illuminate\Validation\Rule;

class RentalsController extends Controller
{
    public function __construct()
    {
      $this->middleware('walkin-rental', ['only' => ['create', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rentals = VanRental::where([['status', '!=', 'Cancelled'],['status', '!=', 'Refunded'], ['status', '!=', 'Expired'], ['status', '!=', 'No Van Available']])
        ->orWhere(function($q){
            $q->where([['status', 'Cancelled']])
            ->where('is_refundable', true);
        })->get();
        return view('rental.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vans = Van::all();
        $drivers = Member::allDrivers()->get();
        $destinations = Destination::allRoute()->get();
        return view('rental.create', compact('vans', 'drivers', 'destinations'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentalRequest $request)
    {
        $time = date('H:i', strtotime($request->time));
        $date = Carbon::parse($request->date);
        $fullName = ucwords(strtolower($request->name));
        if($request->destination == 'otherDestination')
        {
            $destination = ucwords(strtolower($request->otherDestination));
        }
        else
        {
            $destination = ucwords(strtolower($request->destination));            
        }

        $codes = VanRental::all();
        $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

        foreach ($codes as $code)
        {
            $allCodes = $code->rental_code;

            do
            {
                $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

            } while ($rentalCode == $allCodes);
        }

            VanRental::create([
                'rental_code' => 'RN'.$rentalCode,
                'customer_name' => $fullName,
                'van_id' => $request->plateNumber,
                'driver_id' => $request->driver,
                'departure_date' => $date,
                'departure_time' => $time,
                'destination' => $destination,
                'number_of_days' => $request->days,
                'contact_number' => $request->contactNumber,
                'is_refundable' => true,
                'rent_type' => 'Walk-in',
                'status' => 'Paid',

            ]);

            return redirect('/home/rental/')->with('success', 'Rental request from ' . $fullName . ' was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VanRental $rental)
    {
        $vans = Van::all();
        $drivers = Member::allDrivers()->get();
        $rules = BookingRules::where('reservation_fee', null)->get()->first();

        return view('rental.show', compact('rental', 'vans', 'drivers', 'rules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VanRental $rental)
    {
      $this->validate(request(),[
        "click" => [
          'required',
          Rule::in(['Paid', 'Departed', 'Cancelled', 'Refunded'])
        ],
      ]);
        $rental->update([
            'status' => request('click'),
        ]);
        return redirect()->back()->with('success', 'Rental requested by ' . $rental->full_name . ' was marked as '. request('click'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VanRental $rental)
    {
        $rental->delete();
        return back()->with('message', 'Successfully Deleted');

    }

    public function updateStatus(VanRental $rental)
    {
        if(request('status') == 'Unpaid')
        {
            $this->validate(request(), [
                'driver' => 'required|numeric',
                'van' => 'required|numeric',
                'status' => [
                    'required',
                    Rule::in(['Unpaid'])
                ],
            ]);

            $rental->update([
                'status' => request('status'),
                'driver_id' => request('driver'),
                'van_id' => request('van'),
            ]);

            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully accepted. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
        elseif(request('status') == 'Decline')
        {
            $rental->update([
                'status' => 'No Van Available',
            ]);
            return redirect(route('rental.index'))->with('success', 'Rental has been declined.');

        }
        elseif(request('status') == 'Paid')
        {
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            $this->validate(request(), [
                'fare' => 'required|numeric|min:1',
                'status' => [
                    'required',
                    Rule::in(['Paid'])
                ],
            ]);

            $rental->update([
                'rental_fare' => request('fare'),
                'status' => request('status'),
                'refund_code' => $refundCode,
                'is_refundable' => true,
            ]);

    
            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully paid. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
        elseif(request('status') == 'Departed')
        {
            $this->validate(request(), [
                'status' => [
                    'required',
                    Rule::in(['Departed'])
                ],
            ]);

            $rental->update([
                'status' => request('status'),
                'is_refundable' => false,
                'refund_code' => null,
            ]);
    
            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully departed. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
        else
        {
            $this->validate(request(), [
                'refund' => 'required|min:0|max:20',
                'status' => [
                    'required',
                    Rule::in(['Refunded'])
                ],
            ]);
            
            if($rental->is_refundable == true)
            {
                if(request('refund') == $rental->refund_code)
                {
                    $rental->update([
                        'status' => request('status'),
                        'is_refundable' => false,
                        'refund_code' => null,
                    ]);
    
                    return redirect(route('rental.index'))->with('success', 'Rental has been successfully refunded.');
                }
                else
                {
                    return back()->withErrors('Refund code does not match, please try again.');
                }
            }
            else
            {
                return back()->withErrors('Rental code '.$rental->rental_code.' cannot be refunded.');
            }
        }
    }

    public function changeDepartureDateTime(Request $request, VanRental $rental)
    {
        if($rental->status == 'Paid')
        {
            // can change the date of departure 2 days before the departure date.
            $date = $rental->departure_date->subDays(2)->formatLocalized('%d %B %Y');
    
            $this->validate(request(), [
                'date' => 'bail|required|date_format:m/d/Y|before:'.$date,
                'time' => ['bail',new checkTime, 'required'],
            ]);
            $time = date('H:i:s', strtotime($request->time));
            $date = Carbon::parse($request->date);
    
            $rental->update([
                'departure_date' => $date,
                'departure_time' => $time,
            ]);

            return back()->with('success', 'You have successfully modified your departure date and time.');
        }
        else
        {
            return back()->withErrors('Cannot modify departure date and time');
        }

    }
}
