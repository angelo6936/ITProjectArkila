<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Ticket;
use App\VanQueue;
use App\Transaction;
use App\Destination;
use Illuminate\Http\Request;

class ViewLiveVanQueueController extends Controller
{
    public function index()
    {
        $terminals = Destination::where('is_terminal', true)->where('is_main_terminal', false)->with('vanQueue')->get();
        
        return view('ticketmanagement.queue', compact('terminals'));
    }

    public function getVanQueue()
    {
    
        $vanqueue = VanQueue::where('queue_number', '1')->with(['van','destination','driver'])->get();

        $tickets = Ticket::whereIn('ticket_number',
                Transaction::where('status', 'OnBoard')->orWhere('status', 'pending')->where('trip_id', null)
                ->get()->pluck('ticket_name'))
                ->with('destination')->limit(32)->get();
        
        $terminalTickets = null;
        foreach($vanqueue as $vq){
          foreach($tickets as $key => $value){
            $desid = $value->destination_id;  
            //echo $desid . ' ' . $ticket->destination->routeDestination . '<br/>';
            foreach($value->destination->routeDestination as $td){
                if($vq->destination_id == $td->pivot->terminal_destination){
                    //echo $value->ticket_id . ' ' . $value->destination->destination_name .'<br/>';
                    $terminalTickets[$vq->destination_id][$key] = [$value->ticket_id => $value->ticket_number];
                }
            }  
          }  
        }
        return response()->json(['vanqueue' => $vanqueue, 'tickets' => $terminalTickets]);
    }


}