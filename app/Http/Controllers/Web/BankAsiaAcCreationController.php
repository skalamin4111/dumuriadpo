<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BankAsiaAcCreation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAsiaAcCreationController extends Controller
{
    public function index(Request $request): View
    {
        $query = BankAsiaAcCreation::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name_bn', 'like', "%{$search}%")
                  ->orWhere('nid_number', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $acCreations = $query->latest()->paginate(10)->withQueryString();

        return view('services.bank-asia.ac-creations.index', compact('acCreations'));
    }

    public function create(): View
    {
        return view('services.bank-asia.ac-creations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'account_type' => 'required|string|in:new,dormant',
            'applicant_name_bn' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'nid_number' => 'required|string|max:100',
            'present_address' => 'required|string',
            'outlet_name_address' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'source_of_funds' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
            'mobile_number' => 'required|string|max:20',
            
            'account_number' => 'nullable|string|max:100',
            'customer_id' => 'nullable|string|max:100',
            
            'applicant_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            'status' => 'required|string|in:pending,submitted,approved,rejected',
            'agent_name' => 'nullable|string|max:255',
            'agent_designation' => 'nullable|string|max:255',
            'agent_mobile' => 'nullable|string|max:20',
        ]);

        $data = $request->except(['applicant_signature']);

        // Default empty values for unused columns to prevent DB exceptions
        $data['applicant_name_en'] = $data['applicant_name_bn'];
        $data['nationality'] = 'Bangladeshi';
        $data['gender'] = 'other';
        $data['religion'] = 'Other';
        $data['nominee_name'] = '';
        $data['nominee_relation'] = '';
        $data['permanent_address'] = $data['present_address'];

        if ($request->hasFile('applicant_signature')) {
            $path = $request->file('applicant_signature')->store('bank-asia/ac-creations', 'public');
            $data['applicant_signature_path'] = $path;
        }

        $acCreation = BankAsiaAcCreation::create($data);

        return redirect()->route('bank-asia.ac-creations.show', $acCreation)
            ->with('status', 'Source of Fund declaration registered successfully.');
    }

    public function show(BankAsiaAcCreation $acCreation): View
    {
        return view('services.bank-asia.ac-creations.show', compact('acCreation'));
    }

    public function edit(BankAsiaAcCreation $acCreation): View
    {
        return view('services.bank-asia.ac-creations.edit', compact('acCreation'));
    }

    public function update(Request $request, BankAsiaAcCreation $acCreation): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'account_type' => 'required|string|in:new,dormant',
            'applicant_name_bn' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'nid_number' => 'required|string|max:100',
            'present_address' => 'required|string',
            'outlet_name_address' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'source_of_funds' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
            'mobile_number' => 'required|string|max:20',
            
            'account_number' => 'nullable|string|max:100',
            'customer_id' => 'nullable|string|max:100',
            
            'applicant_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            'status' => 'required|string|in:pending,submitted,approved,rejected',
            'agent_name' => 'nullable|string|max:255',
            'agent_designation' => 'nullable|string|max:255',
            'agent_mobile' => 'nullable|string|max:20',
        ]);

        $data = $request->except(['applicant_signature']);
        $data['applicant_name_en'] = $data['applicant_name_bn'];
        $data['permanent_address'] = $data['present_address'];

        if ($request->hasFile('applicant_signature')) {
            if ($acCreation->applicant_signature_path) {
                Storage::disk('public')->delete($acCreation->applicant_signature_path);
            }
            $path = $request->file('applicant_signature')->store('bank-asia/ac-creations', 'public');
            $data['applicant_signature_path'] = $path;
        }

        $acCreation->update($data);

        return redirect()->route('bank-asia.ac-creations.show', $acCreation)
            ->with('status', 'Source of Fund declaration updated successfully.');
    }

    public function destroy(BankAsiaAcCreation $acCreation): RedirectResponse
    {
        if ($acCreation->applicant_signature_path) {
            Storage::disk('public')->delete($acCreation->applicant_signature_path);
        }

        $acCreation->delete();

        return redirect()->route('bank-asia.ac-creations.index')
            ->with('status', 'Source of Fund declaration deleted successfully.');
    }
}
