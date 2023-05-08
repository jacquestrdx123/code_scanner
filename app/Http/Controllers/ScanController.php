<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScanController extends Controller
{
    public function store(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        $input = $request->all();
        if(array_key_exists('station',$input)){
            switch ($input['station']) {
                case 1:
                    $scan = Scan::firstOrNew([
                        'order_number' => $input['order_number']
                    ], [
                        'order_number' => $input['order_number'],
                        'current_state' => 'order',
                        'order_time' => $currentDateTime
                    ]);
                    if (!$scan->exists) {
                        $scan->save(); // Creates a new user
                        \Session::flash('success', "Order number captured successfully");
                    }else{
                        \Session::flash('error', "Order number captured successfully");
                    }
                    return redirect()->back();
                case 2:
                    $scan = Scan::where('order_number',$input['order_number'])->first();
                    if ($scan->isNotEmpty()) {
                        $scan->picking_time = $currentDateTime;
                        $scan->current_state = 'picking';
                        $scan->save();
                        \Session::flash('success', "Order number captured successfully");
                    }else{
                        \Session::flash('error', "Order number captured does not exist");
                    }
                    return redirect()->back();
                case 3:
                    return view('scans.scan_invoice');
                case 4:
                    return view('scans.scan_loading');
                case 5:
                    return view('scans.scan_security');
                case 6:
                    return view('scans.scan_pod');
                default:
                    return view('dashboard');
            }
        }
    }

    public function show($id){
        switch ($id) {
            case 1:
                return view('scans.scan_order');
            case 2:
                return view('scans.scan_picking');
            case 3:
                return view('scans.scan_invoice');
            case 4:
                return view('scans.scan_loading');
            case 5:
                return view('scans.scan_security');
            case 6:
                return view('scans.scan_pod');
            default:
                return view('dashboard');
        }
    }

    public function showUpdate($id){
        $scan = Scan::find($id);
        return view('update_scan',compact('scan'));
    }

    public function index(){
        $scans = Scan::paginate(10);
        return view('scans.index',compact('scans'));
    }

    public function exportToExcel(Request $request){
        $input = $request->all();
        if(array_key_exists('start_date',$input)){
            $start = $input['start_date'];
        }else{
            $start = ' 2000-10-26 09:00:48';
        }
        if(array_key_exists('end_date',$input)){
            $end = $input['end_date'];
        }
        else{
            $end = ' 2100-10-26 09:00:48';
        }
        if($start == null){
            $start = ' 2000-10-26 09:00:48';
        }
        if($end == null){
            $end = ' 2100-10-26 09:00:48';
        }

        $scans = Scan::where('created_at','>',$start)->where('created_at','<',$end)->get();
        $array = array();
        $array[] = [
            "Order Number",
            "Invoice Number",
            "Order Date",
            "Picking Date",
            "Confirmation Date",
            "Invoice Date",
            "Loading Date",
            "Loading Registration",
            "Security Registration",
            "Security Date",
            "Proof of Delivery Date",
            ];
        foreach($scans as $scan){
            $array[] = [
                $scan->order_number,
                $scan->invoice_number,
                $scan->order_time,
                $scan->picking_time,
                $scan->confirmation_time,
                $scan->invoice_time,
                $scan->loading_time,
                $scan->loading_registration,
                $scan->security_time,
                $scan->security_registration,
                $scan->pod_time
            ];
        }
        $xlsx = \App\SimpleXLSXGen::fromArray( $array );
        $date = date("Y-m-d");
        $xlsx->downloadAs('scans'.$date.'.xlsx');
    }

}
