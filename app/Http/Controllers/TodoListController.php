<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Order;
use App\Models\TodoList;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'user' => User::where('role', 'support')->with('todos')->get(),
            'todo' => TodoList::all()
        ]);
    }
    public function getDataByUser($todolist)
    {
        $todoList = TodoList::where('user_id', $todolist)->with('order.user', 'order.template', 'order.package')->get();
        return response()->json($todoList);
    }
    public function changeStatus(Request $request)
    {
        $todoList = TodoList::find($request->id);
        $todoList->status = $request->status;
        $todoList->save();

        return response()->json($todoList);
    }
    public function changeNote(Request $request)
    {
        $todoList = TodoList::find($request->id);
        $todoList->note = $request->note;
        $todoList->save();

        return response()->json($todoList);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $todoList = new TodoList();
        $todoList->user_id = $request->user_id;
        $todoList->note = $request->note;
        $todoList->save();
        return response()->json(TodoList::find($todoList->id));
    }
    public function submit(Request $request)
    {
        $todo = [];
        foreach ($request->todo as $td) {
            $td = TodoList::find($td);
            $td->status = 'submited';
            $td->submit_at = now();
            $td->save();
            $todo[] = $td;
        }
        return response()->json($todo);
    }
    public function confirmOrder(Request $request)
    {
        // return response()->json($request->todolist_id);
        $validator = Validator::make($request->all(), [
            'domain_name' => 'required|string|max:255|unique:domains',
            'vendor' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $domain = new Domain();
        $domain->domain_name = $request->domain_name;
        $domain->start_date = $request->start_date;
        $domain->expired_date = $request->expired_date;
        $domain->description = $request->description;
        $vendorExist = Vendor::where('vendor_name', $request->vendor)->first();
        if ($vendorExist) {
            $domain->vendor_id = $vendorExist->id;
        } else {
            $vendor = new Vendor();
            $vendor->vendor_name = $request->vendor;
            $vendor->save();
            $domain->vendor_id = $vendor->id;
        }

        $domain->user_id = $request->user_id;
        $domain->save();

        $order = Order::find($request->order_id);
        $order->status_order = 'DONE';
        $order->save();

        $todolist = TodoList::find($request->todolist_id);
        $todolist->status = 'submited';
        $todolist->save();
        return response()->json($request->todolist_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $todoList)
    {
        $todoList->delete();
        return response()->json($todoList);
    }
}
