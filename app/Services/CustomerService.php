<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(private readonly CustomerRepositoryInterface $customers)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->customers->paginate($filters);
    }

    public function create(array $data): Customer
    {
        $data['company_id'] ??= auth()->user()?->company_id;

        return $this->customers->create($data);
    }

    public function update(Customer $customer, array $data): Customer
    {
        return $this->customers->update($customer, $data);
    }
}
