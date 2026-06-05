<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerService $customers)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Customer::class);

        return view('customers.index', ['customers' => $this->customers->paginate($request->query())]);
    }

    public function store(CustomerRequest $request)
    {
        $this->customers->create($request->validated());
        return back()->with('status', 'Customer created.');
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->customers->update($customer, $request->validated());
        return back()->with('status', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();
        return back()->with('status', 'Customer archived.');
    }
}
