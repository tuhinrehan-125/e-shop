<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Collection;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Products;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;
use Hash;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
class UserController extends Controller
{
    public function index()
    {
        $business_id=auth()->user()->business_id;
        $users = User::where('business_id', $business_id)->latest()->get();
        return response(UserResource::collection($users), Response::HTTP_OK);
    }

    public function createUserOfBusiness(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $user_details = $request->only(['surname', 'first_name', 'last_name', 'username', 'email', 'password']);
        $user_details['business_id'] = auth()->user()->business_id;
        $user_details['password'] = bcrypt($user_details['password']);
        $user = User::create($user_details);
        $role_id = $request->input('role');
        $role = Role::findOrFail($role_id);
        $user->assignRole($role->name);

        $user->locations()->attach($request->location_id);

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    public function dashboardData(Request $request)
    {
        if ($request->reportfor == 'weekly') {
            $startDate = Carbon::now()->startOfWeek(Carbon::SATURDAY);
            $endDate =  Carbon::now()->endOfWeek(Carbon::THURSDAY);
        } elseif ($request->reportfor == 'monthly') {
            $startDate = new Carbon('first day of this month');
            $endDate = new Carbon('last day of this month');
        } elseif ($request->reportfor == 'daily') {
            $startDate = Carbon::today();
            $endDate = Carbon::tomorrow();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }
        $lastestPayment = Payment::leftjoin('banks', 'banks.id', '=', 'payments.bank_id')->select('select_mode', 'banks.name as bank_name', 'payments.created_at', 'payment_amount')->orderBY('payments.id', 'desc')->take(4)->get();

        $totalCollection = Collection::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        $countClient = Client::all()->count();
        $countCustomer = Customer::all()->count();

        $regular_customers = Customer::join('order_products', 'customers.id', '=', 'order_products.customer_id')
            ->selectRaw('customers.*, COALESCE(sum(order_products.quantity),0) total_purchse, sum(order_products.total) as total_amount')
            ->where('customers.delete_status', 1)
            ->groupBy('customers.id')
            ->orderBy('total_purchse', 'desc')
            ->take(4)
            ->get();

        $popular_fish = Products::join('order_products', 'products.id', '=', 'order_products.product_id')
            ->selectRaw("products.*, sum(order_products.total) as total_amount")
            ->where('products.delete_status', 1)
            ->groupBy('products.id')
            ->orderBy('total_amount', 'desc')
            ->take(4)
            ->get();
        $commissions = Setting::select('arot_commission', 'bazar_commission')->first();

        $data = array(
            'totalcollection' => strval($totalCollection),
            'totalclient' => strval($countClient),
            'totalcustomer' => strval($countCustomer),
            'regular_customers' => $regular_customers,
            'popular_fish' => $popular_fish,
            'latest_payment' => $lastestPayment,
            'commissions' => $commissions
        );

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('first_name')) {
            $user->first_name = $request->first_name;
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
        }
        if ($request->has('phone_no')) {
            $user->phone_no = $request->phone_no;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('email_address')) {
            $user->email_address = $request->email_address;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Updated successfully'], 200);
    }
}
