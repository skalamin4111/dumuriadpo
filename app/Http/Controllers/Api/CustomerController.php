<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
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

        return CustomerResource::collection($this->customers->paginate($request->query()));
    }

    public function store(CustomerRequest $request)
    {
        return new CustomerResource($this->customers->create($request->validated()));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return new CustomerResource($customer->loadCount('tasks'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        return new CustomerResource($this->customers->update($customer, $request->validated()));
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();
        return response()->noContent();
    }
}
