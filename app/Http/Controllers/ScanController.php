<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function store(Request $request){
        $input = $request->all();
        if(array_key_exists('order_number',$input)){
            $currentDateTime = date('Y-m-d H:i:s');
            $scan = Scan::where('order_number', $input['order_number'])->firstOrCreate([
                'order_number' => $input['order_number']
            ]);
        }
        dd($scan);
        if($scan->current_state=="created"){
            $scan->current_state = "order";
            $scan->order_time = $currentDateTime;
            $scan->save();
        }
        return redirect('/update-scan/'.$scan->id);
    }
    public function updateScan(Request $request){
        $input = $request->all();
        if(array_key_exists('order_number',$input)){
            $currentDateTime = date('Y-m-d H:i:s');
            $scan = Scan::where('order_number', $input['order_number'])->firstOrCreate([
                'order_number' => $input['order_number']
            ]);
            if($scan->current_state=="confirmation_of_picking"){
                $scan->current_state = "invoice";
                $scan->invoice_number = $input['invoice_number'];
                $scan->invoice_time = $currentDateTime;
                $scan->save();
            }
            if($scan->current_state=="picked"){
                $scan->current_state = "confirmation_of_picking";
                $scan->confirmation_time = $currentDateTime;
                $scan->save();
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


        }else{
            if(array_key_exists('invoice_number',$input)){
                $currentDateTime = date('Y-m-d H:i:s');
                $scan = Scan::where('invoice_number', $input['invoice_number'])->firstOrCreate([
                    'invoice_number' => $input['invoice_number']
                ]);
                if($scan->current_state=="security"){
                    $scan->current_state = "proof_of_delivery";
                    $scan->pod_time = $currentDateTime;
                    $scan->save();
                }
                if($scan->current_state=="loading"){
                    $scan->current_state = "security";
                    $scan->security_registration = $input['security_registration'];
                    $scan->security_time = $currentDateTime;
                    $scan->save();
                }
                if($scan->current_state=="invoice"){
                    $scan->current_state = "loading";
                    $scan->loading_registration = $input['loading_registration'];
                    $scan->loading_time = $currentDateTime;
                    $scan->save();
                }


            }
        }


        return redirect('/');
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
        $array[] = ["Number","Date"];
        foreach($scans as $scan){
            $array[] = [$scan->code,$scan->created_at];
        }
        $xlsx = \App\SimpleXLSXGen::fromArray( $array );
        $date = date("Y-m-d");
        $xlsx->downloadAs('scans'.$date.'.xlsx');
    }

}
