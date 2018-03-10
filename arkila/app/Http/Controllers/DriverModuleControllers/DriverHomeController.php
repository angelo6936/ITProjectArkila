<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Announcement;
use App\Trip;

class DriverHomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth::driver');
    // }

    public function index()
    {
      $announcements = Announcement::latest()->where('viewer', '=', 'Public')
                                    ->orWhere('viewer', '=', 'Driver Only')->get();
      $trips = Trip::join('member', 'trip.driver_id', '=', 'member.member_id')
                    ->join('destination', 'trip.destination_id', '=', 'destination.destination_id')
                    ->join('terminal', 'destination.terminal_id', '=', 'terminal.terminal_id')
                    ->join('van', 'trip.plate_number', '=', 'van.plate_number')
                    ->where('member.operator_id', '=', null)
                    ->where('member.role', '=', 'Driver')
                    ->where('trip.status', '<>', 'Departed')
                    ->orderBy('trip.created_at','asc')
                    ->select('trip.trip_id as trip_id', 'trip.queue_number as queueId', 'trip.plate_number as plate_number', 'trip.remarks as remarks', 'terminal.description as terminaldesc')->get();
      return view('drivermodule.index', compact('announcements', 'trips'));
    }
}