<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RouteRequest;
use App\Destination;
use App\Ticket;


class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terminals = Destination::allTerminal()->get();
        $mainTerminal = Destination::all()->where('is_main_terminal', 1);
        return view('route.index', compact('terminals', 'mainTerminal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terminals = Destination::allTerminal()->get();
        return view('route.create', compact('terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RouteRequest $request)
    {
        $name = ucwords(strtolower($request->addTerminal));
        $terminals = Destination::allTerminal()->get();
        $main = Destination::where('is_main_terminal', '1')->first();
        $message = null;
        $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        if ($request->termRoute == 'Terminal')
        {    
            $terminal = Destination::create([
                'destination_name' => $name,
                'booking_fee' => $request->bookingFee,
                'short_trip_fare' => $request->sTripFare,
                'short_trip_fare_discount' => $request->sdTripFare,
                'is_terminal' => true,
                'is_main_terminal' => false,
            ]);

            foreach($discountedTickets as $discountedTicket)
            {
                $ticketNumber = $name.'-'.$discountedTicket;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $terminal->destination_id,
                    'is_sold' => false,
                    'fare' => $request->discountedFare,
                    'type' => 'Discount'
                ]);
            }

            for($i=1; $i <= $request->numticket; $i++ )
            {
                $ticketName = $name.'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $terminal->destination_id,
                    'is_sold' => false,
                    'fare' => $request->regularFare,
                    'type' => 'Regular'
                ]);
            }
            $message = 'The terminal '. $name .' has been successfully created';
        }
        else 
        {

            $route = Destination::create([
                'destination_name' => $name,
                'is_terminal' => false,
                'is_main_terminal' => false,
            ]);

            foreach($discountedTickets as $discountedTicket)
            {
                $ticketNumber = $name.'-'.$discountedTicket;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $route->destination_id,
                    'is_sold' => false,
                    'fare' => $request->discountedFare,
                    'type' => 'Discount'
                ]);
            }

            for($i=1; $i <= $request->numticket; $i++ )
            {
                $ticketName = $name.'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $route->destination_id,
                    'is_sold' => false,
                    'fare' => $request->regularFare,
                    'type' => 'Regular'
                ]);
            }

            foreach ($terminals as $count => $terminal) {
                if (isset($request->dest[$count])) {
                    $route->routeOrigin()
                    ->attach($main->destination_id, ['terminal_destination' => $request->dest[$count]]);
                } 
            }   
            $message = 'The route '. $name .' has been successfully created';

        }
        return redirect('/home/route/')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
