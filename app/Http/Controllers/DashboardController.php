<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Order;
use App\Models\TodoList;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'domain' => Domain::count(),
            'user' => User::where('role', 'user')->count(),
            'vendor' => Vendor::count(),
            'unpaid_order' => Order::where('status_payment', 'PENDING')->count(),
            'processing_order' => Order::where('status_payment', 'PAID')->where('status_order', 'PROCESSING')->count(),
            'success_order' => Order::where('status_order', 'DONE')->count(),
        ]);
    }
    public function indexSupport(User $user)
    {
        return response()->json([
            'todolist' => $user->todos()->whereHas('order')->with('order')->orderBy('created_at', 'desc')->get(),
            'todo_count' => $user->todos()->where('status', 'todo')->count(),
            'doing_count' => $user->todos()->where('status', 'doing')->count(),
            'done_count' => $user->todos()->where('status', 'done')->count(),
        ]);
    }
}
