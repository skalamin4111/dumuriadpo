<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Reminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ReminderController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'service_section', 'search']);

        $reminders = Reminder::query()
            ->with(['customer', 'officer'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['service_section'] ?? null, fn ($query, $service) => $query->where('service_section', $service))
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('purpose', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn ($customer) => $customer
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%"));
                });
            })
            ->orderByRaw("case when status = 'pending' then 0 else 1 end")
            ->orderBy('remind_at')
            ->paginate(12)
            ->withQueryString();

        return view('reminders.index', [
            'customers' => Customer::orderBy('name')->get(),
            'contactTypes' => Reminder::CONTACT_TYPES,
            'reminders' => $reminders,
            'services' => Reminder::SERVICES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'service_section' => ['required', Rule::in(array_keys(Reminder::SERVICES))],
            'contact_type' => ['required', Rule::in(array_keys(Reminder::CONTACT_TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'follow_up_notes' => ['nullable', 'string'],
            'remind_at' => ['required', 'date'],
        ]);

        Reminder::create([
            ...$data,
            'company_id' => $request->user()?->company_id,
            'user_id' => $request->user()->id,
            'status' => 'pending',
            'is_sent' => false,
        ]);

        return back()->with('status', 'Reminder created.');
    }

    public function update(Request $request, Reminder $reminder): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'completed', 'cancelled'])],
        ]);

        $reminder->update([
            'status' => $data['status'],
            'completed_at' => $data['status'] === 'completed' ? now() : null,
        ]);

        return back()->with('status', 'Reminder updated.');
    }
}
