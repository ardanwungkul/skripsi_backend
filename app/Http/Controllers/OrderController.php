<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Template;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\CustomerObject;
use Xendit\Invoice\Invoice;
use Xendit\Invoice\InvoiceApi;
use Xendit\Xendit;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Order::with('user')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'package' => Package::all(),
            'template' => Template::all()
        ]);
    }

    public function dataByUserId($id)
    {
        $order = Order::where('user_id', $id)->with('template', 'user', 'package')->orderBy('created_at', 'desc')->get();
        return response()->json($order);
    }
    public function dataByCode($code)
    {

        $order = Order::where('order_code', $code)->with('template', 'user', 'package')->first();
        if ($order->status_payment !== 'SUBMIT') {
            Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
            $apiInstance = new InvoiceApi();
            $invoiceId = $order->invoice_id;
            $result = $apiInstance->getInvoiceById($invoiceId);
            $response = json_decode($result);
            if ($response->status == 'SETTLED') {
                $order->status_payment = 'PAID';
            } else {
                $order->status_payment = $response->status;
            }
            $order->save();
        }
        return response()->json($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json($request);
        $validator = Validator::make($request->all(), [
            'domain_name' => 'required',
            'package' => 'required',
            'template' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $order = new Order();
        $order->domain_name = $request->domain_name;
        $order->order_code = $this->generateTransactionCode();
        $order->package_id = $request->package;
        $order->description = $request->description;
        $order->template_id = $request->template;
        $order->user_id = $request->user_id;
        $order->amount = $request->amount;
        $order->status_payment = 'SUBMIT';
        $order->save();

        return response()->json($order);
    }
    public function process(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status_order = 'PROCESSING';
        $order->save();
        $todo = new TodoList();
        $todo->note = $order->description ? $order->description : '';
        $todo->order_id = $order->id;
        $todo->user_id = $request->user_id;
        $todo->save();
        return response()->json($order->load('user'));
    }
    public function generateTransactionCode()
    {
        $timestamp = time();
        $randomString = Str::random(12);
        $transactionCode = 'TRX-' . $timestamp . '-' . $randomString;

        return $transactionCode;
    }

    public function payment(Request $request)
    {
        $order = Order::with('template', 'package', 'user')->find($request->order_id);

        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
        $apiInstance = new InvoiceApi();
        $customer = new CustomerObject([
            // 'phone_number' => '081223410886',
            // 'mobile_number' => '081223410886',
            'given_names' => $order->user->name,
            'email' => $order->user->email,

        ]);
        $success_redirect_url = route('order.return', $order->order_code);
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $order->order_code,
            'payer_email' => $order->user->email,
            'should_send_email' => 'true',
            'description' => 'Pembayaran Order Website ' . $order->domain_name,
            'amount' => $order->amount,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 1,
            'customer' => $customer,
            'success_redirect_url' => $success_redirect_url
        ]);
        $result = $apiInstance->createInvoice($create_invoice_request);
        $response = json_decode($result);
        $order->invoice_id = $response->id;
        $order->status_payment = $response->status;
        $order->save();

        return response()->json($result);
    }
    public function return($code)
    {
        $order = Order::where('order_code', $code)->first();

        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
        $apiInstance = new InvoiceApi();
        $invoiceId = $order->invoice_id;
        $result = $apiInstance->getInvoiceById($invoiceId);
        $response = json_decode($result);
        if ($response->status == 'SETTLED') {
            $order->status_payment = 'PAID';
        } else {
            $order->status_payment = $response->status;
        }
        $order->save();
        return Redirect::away(env('FRONTEND_URL') . '/order/checkout/' . $code);
    }
}
