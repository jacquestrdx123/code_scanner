<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function store(Request $request){
        $input = $request->all();
        if(array_key_exists('input',$input)){
            if (strcasecmp(substr($input['input'], 0, 3), 'inv') === 0) {
                $scan = Scan::where('invoice_number',$input['input'])->first();
                return redirect('/update-scan/'.$scan->id);

            }elseif(strcasecmp(substr($input['input'], 0, 2), 'po') === 0){
                $scan_collection = Scan::where('order_number', $input['input'])->firstOrCreate([
                    'order_number' => $input['input']
                ]);
            }
        }
        $currentDateTime = date('Y-m-d H:i:s');
        try{
            $scan = Scan::find($scan_collection->id);
        }catch (\Exception $e){
            $flash = "Error!! Order not found!";
            return redirect('/')->with('error', $flash);;

        }

        if($scan->current_state=="confirmation_of_picking"){
            return redirect('/update-scan/'.$scan->id);
        }

        if($scan->current_state=="picked"){
            $scan->current_state = "confirmation_of_picking";
            $scan->confirmation_time = $currentDateTime;
            $scan->save();
            $flash = "Picking confirmed";
            return redirect('/')->with('success', $flash);
        }
        if($scan->current_state=="order"){
            $scan->current_state = "picked";
            $scan->picking_time = $currentDateTime;
            $scan->save();
        }
        if($scan->current_state=="created"){
            $scan->current_state = "order";
            $scan->order_time = $currentDateTime;
            $scan->save();
        }
        switch ($scan->current_state) {
            case "order":
                $flash = "Changed to Order successfully!";
                break;
            case "picked":
                $flash = "Changed to Picked successfully!";
                break;
            case "confirmation_of_picking":
                $flash = "Picking confirmed";
                break;
            default:
                $flash = "Loaded Scan";
                break;
        }
        return redirect('/')->with('success', $flash);
    }
    public function updateScan(Request $request){
        $input = $request->all();
        $scan = Scan::find($input['scan_id']);
        $currentDateTime = date('Y-m-d H:i:s');
        if(array_key_exists('invoice_number',$input)){
                if($scan->current_state=="confirmation_of_picking") {
                    $scan->invoice_number = $input['invoice_number'];
                    $scan->current_state = "invoice";
                    $scan->invoice_time = $currentDateTime;
                    $scan->save();
                }
                if($scan->current_state=="security"){
                    if($input['invoice_number']!==$scan->invoice_number){
                        $flash = "Error!! Order not found!";
                        return redirect('/')->with('error', $flash);
                    }
                    $scan->current_state = "proof_of_delivery";
                    $scan->pod_time = $currentDateTime;
                    $scan->save();
                }
        }
        if(array_key_exists('loading_registration',$input)){
            if($scan->current_state=="invoice"){
                $scan->current_state = "loading";
                $scan->loading_registration = $input['loading_registration'];
                $scan->loading_time = $currentDateTime;
                $scan->save();
            }
        }
        if(array_key_exists('security_registration',$input)){
            if($scan->current_state=="loading"){
                $scan->current_state = "security";
                $scan->security_registration = $input['security_registration'];
                $scan->security_time = $currentDateTime;
                $scan->save();
            }
        }
        switch ($scan->current_state) {
            case "invoice":
                $flash = "Invoice Captured!";
                break;
            case "loading":
                $flash = "Loading Registration Captured";
                break;
            case "security":
                $flash = "Security Registration Captured";
                break;
            case "proof_of_delivery":
                $flash = "Order Completed";
                break;
            default:
                $flash = "Loaded Scan";
                break;
        }

        return redirect('/')->with('success', $flash);
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
            "Loading Date",
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
