<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TripReportsAdminNotification;
use App\Http\Requests\CreateReportRequest;
use App\Http\Controllers\Controller;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use Carbon\Carbon;
use App\Destination;
use App\Transaction;
use App\Terminal;
use App\Member;
use App\Ticket;
use App\Trip;
use App\User;
use App\Fee;
class CreateReportController extends Controller
{
  
  public function createReport()
  {
    $origins = Destination::where('is_terminal', true)->where('is_main_terminal', false)->get();
    $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first();
    //$destinations = $terminals->routeFromDestination;
    $fees = Fee::all();
    $dateNow = Carbon::now()->format('m/d/Y');
    $timeNow = Carbon::now()->format('g:i A');

    $member = Member::where('user_id', Auth::id())->first();
    return view('drivermodule.report.driverCreateReport', compact('dateNow', 'timeNow','terminals', 'destinations', 'fad', 'member', 'origins'));
  }
  public function storeReport(CreateReportRequest $request)
  {
    //dd(request('destinationName'));
    $terminal = Destination::find($request->origin);
    $totalPassengers = $request->totalPassengers;

    $totalPassenger = (float)$request->totalPassengers;
    $cf = Fee::where('description', 'Community Fund')->first();
    $totalbookingfee = number_format($terminal->booking_fee * $totalPassenger, 2, '.', '');

    $sop = Fee::where('description', 'SOP')->first();

    $driver_user = User::find(Auth::id());
    $van_id = $driver_user->member->van->first()->van_id;
    $driver_id = Member::where('user_id', Auth::id())->select('member_id')->first();

    $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
    $timeDepartedFormat = $timeDeparted->format('H:i:s');
    $dateDeparted = $request->dateDeparted;

    $mainterminal = Destination::where('is_main_terminal', true)->first();

    $trip =Trip::create([
     'driver_id' => $driver_id->member_id,
     'van_id' => $van_id,
     'destination' => $mainterminal->destination_name,
     'origin' => $terminal->destination_name,
     'total_passengers' => $totalPassengers,
     'total_booking_fee' => $totalbookingfee,
     'community_fund' => $cf->amount*$totalPassengers,
     'report_status' => 'Pending',
     'date_departed' => $request->dateDeparted,
     'time_departed' => $timeDepartedFormat,
     'reported_by' => 'Driver',
   ]);

     $numberofmainpassengers = $request->numPassMain;
     $numberofmaindiscount = $request->numDisMain;
     $numberofstpassengers = $request->numPassST;
     $numberofstdiscount = $request->numDisST;
     $shortTripFare = $terminal->short_trip_fare;
     $shortTripDiscountFare = $terminal->short_trip_fare_discount;
     
     //1. If all are true
     if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
        ($numberofstpassengers !== null && $numberofstdiscount !== null)){
          for($i = 0; $i < $numberofmainpassengers; $i++){
            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
            $amountpaid = $terminalfare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_trip_type" => "Regular",
            ]);
          }

          for($i = 0; $i < $numberofmaindiscount; $i++){
            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
            $amountpaid = $terminalfare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_trip_type" => "Discount",
            ]);
          }

          for($i = 0; $i < $numberofstpassengers; $i++){
            $amountpaid = $shortTripFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_trip_type" => "Regular",
            ]);
          }

          for($i = 0; $i < $numberofstdiscount; $i++){
            $amountpaid = $shortTripDiscountFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_trip_type" => "Discount",
            ]);
          }
      //2. If num of dis main pass is false     
     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
     ($numberofstpassengers !== null && $numberofstdiscount !== null)){
        for($i = 0; $i < $numberofmainpassengers; $i++){
          $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
          $amountpaid = $terminalfare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }

        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }
      //3. If num of dis main pass and num st pass is false     
     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
     ($numberofstpassengers == null && $numberofstdiscount !== null)){
        for($i = 0; $i < $numberofmainpassengers; $i++){
          $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
          $amountpaid = $terminalfare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }
     //4. If num of dis main pass, num st pass, and num st pass are false     
     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
     ($numberofstpassengers == null && $numberofstdiscount == null)){
        $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;

        for($i = 0; $i < $numberofmainpassengers; $i++){
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }
      //5. If num main pass is false
      }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
      ($numberofstpassengers !== null && $numberofstdiscount !== null)){
        for($i = 0; $i < $numberofmaindiscount; $i++){
          $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
          $amountpaid = $terminalfare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }

        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }
      //6. if num main pass and num main dis pass are false
      }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
      ($numberofstpassengers !== null && $numberofstdiscount !== null)){
        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Regular",
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }
      //7. if num main pass, num main dis pass, and  are false
      }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
      ($numberofstpassengers == null && $numberofstdiscount !== null)){
        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_trip_type" => "Discount",
          ]);
        }
      }
      
      

      return redirect('/home/create-report')->with('success', 'Report created successfully!');

  }
}
