<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
                        \Session::flash('success', "Order number captured successfully on system");
                    }else{
                        \Session::flash('error', "Order number captured successfully");
                    }
                    return redirect()->back();
                case 2:
                    $scan = Scan::where('order_number',$input['order_number'])->first();
                    if ($scan->count()) {
                        $scan->picking_name = $input['name'];
                        $scan->picking_time = $currentDateTime;
                        $scan->current_state = 'picking';
                        $scan->save();
                        \Session::flash('success', "Order number captured successfully to Picking");
                    }else{
                        \Session::flash('error', "Order number captured does not exist");
                    }
                    return redirect()->back();
                case 3:
                    $scan = Scan::where('order_number',$input['order_number'])->first();
                    if ($scan->count()) {
                        $scan->confirm_name = $input['name'];
                        $scan->confirmation_time = $currentDateTime;
                        $scan->current_state = 'confirm_picking';
                        $scan->save();
                        \Session::flash('success', "Order number captured successfully");
                    }else{
                        \Session::flash('error', "Order number captured does not exist");
                    }
                    return redirect()->back();
                case 4:
                    $scan = Scan::where('order_number',$input['order_number'])->first();
                    if ($scan->count()) {
                        $scan->current_state = 'invoice';
                        if(array_key_exists('invoices',$input)){
                            foreach($input['invoices'] as $invoice){
                               $invoice_obj = new Invoice();
                               $invoice_obj->scan_id = $scan->id;
                               $invoice_obj->invoice_number = $invoice;
                               $invoice_obj->save();
                               $scan->invoice_time = $currentDateTime;
                            }
                        }
                        $scan->save();
                        \Session::flash('success', "Invoice number captured successfully to $scan->order_number");
                        return redirect()->back();
                    }else{
                        \Session::flash('error', "Order number captured does not exist");
                        return redirect()->back();
                    }
                case 5:
                    $invoice = Invoice::where('invoice_number',$input['invoice_number'])->first();
                    if ($invoice->count()) {
                        $invoice->loading_registration = $input['loading_registration'];
                        $invoice->loading_time = $currentDateTime;
                        $invoice->save();
                        \Session::flash('success', "Invoice number captured successfully at Loading");
                        return redirect()->back();
                    }else{
                        \Session::flash('error', "Invoice number captured does not exist");
                        return redirect()->back();
                    }
                case 6:
                    $invoice = Invoice::where('invoice_number',$input['invoice_number'])->first();
                    if ($invoice->count()) {
                        $invoice->security_name = $input['security_name'];
                        $invoice->security_time = $currentDateTime;
                        $invoice->save();
                        \Session::flash('success', "Invoice number captured successfully at Security");
                        return redirect()->back();
                    }else{
                        \Session::flash('error', "Invoice number captured does not exist");
                        return redirect()->back();
                    }
                case 7:
                    $invoice = Invoice::where('invoice_number',$input['invoice_number'])->first();
                    if ($invoice->count()) {
                        $invoice->pod_time = $currentDateTime;
                        $invoice->save();
                        \Session::flash('success', "Invoice number captured successfully at Delivery");
                        return redirect()->back();
                    }else{
                        \Session::flash('error', "Invoice number captured does not exist");
                        return redirect()->back();
                    }
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
                return view('scans.scan_confirm_picking');
            case 4:
                return view('scans.scan_invoice');
            case 5:
                return view('scans.scan_loading');
            case 6:
                return view('scans.scan_security');
            case 7:
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
        $scans = Scan::with('invoices')->paginate(10);

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

        $invoices = Invoice::with('scan')->where('created_at','>',$start)->where('created_at','<',$end)->get();
        $array = array();
        $array[] = [
            "Order Number",
            "Invoice Number",
            "Order Date",
            "Picking Date",
            "Picking Name",
            "Confirmation Date",
            "Confirmation Name",
            "Invoice Date",
            "Loading Date",
            "Loading Registration",
            "Security Name",
            "Security Date",
            "Proof of Delivery Date",
            ];
        foreach($invoices as $invoice){
            $array[] = [
                $invoice->scan->order_number,
                $invoice->invoice_number,
                $invoice->scan->order_time,
                $invoice->scan->picking_time,
                $invoice->scan->picking_name,
                $invoice->scan->confirmation_time,
                $invoice->scan->confirm_name,
                $invoice->scan->invoice_time,
                $invoice->loading_time,
                $invoice->loading_registration,
                $invoice->security_name,
                $invoice->security_time,
                $invoice->pod_time
            ];
        }
        $xlsx = \App\SimpleXLSXGen::fromArray( $array );
        $date = date("Y-m-d");
        $xlsx->downloadAs('scans'.$date.'.xlsx');
    }

}
