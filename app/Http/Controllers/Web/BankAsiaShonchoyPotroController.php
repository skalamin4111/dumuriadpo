<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BankAsiaShonchoyPotro;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAsiaShonchoyPotroController extends Controller
{
    public function index(Request $request): View
    {
        $query = BankAsiaShonchoyPotro::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('purchaser_name', 'like', "%{$search}%")
                  ->orWhere('purchaser_nid', 'like', "%{$search}%")
                  ->orWhere('purchaser_phone', 'like', "%{$search}%")
                  ->orWhere('certificate_number', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type')) {
            $query->where('certificate_type', $request->input('type'));
        }

        $certificates = $query->latest()->paginate(10)->withQueryString();

        return view('services.bank-asia.shonchoy-potros.index', compact('certificates'));
    }

    public function create(): View
    {
        return view('services.bank-asia.shonchoy-potros.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'purchaser_name' => 'required|string|max:255',
            'purchaser_nid' => 'required|string|max:30',
            'purchaser_phone' => 'required|string|max:20',
            'purchaser_dob' => 'required|date',
            'purchaser_address' => 'required|string',
            
            'certificate_type' => 'required|string|in:family,3_month_interest,pensioner,5_year_bd',
            'certificate_number' => 'required|string|max:100',
            'registration_number' => 'required|string|max:100',
            'purchase_date' => 'required|date',
            'maturity_date' => 'required|date|after_or_equal:purchase_date',
            'purchase_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            
            'nominee_name' => 'required|string|max:255',
            'nominee_relation' => 'required|string|max:100',
            'nominee_share_percent' => 'required|integer|min:1|max:100',
            
            'status' => 'required|string|in:active,matured,encashed',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        $data = $request->except(['document']);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('bank-asia/shonchoy-potros', 'public');
            $data['document_path'] = $path;
        }

        $certificate = BankAsiaShonchoyPotro::create($data);

        return redirect()->route('bank-asia.shonchoy-potros.show', $certificate)
            ->with('status', 'Savings certificate record created successfully.');
    }

    public function show(BankAsiaShonchroPotro|BankAsiaShonchoyPotro $certificate): View
    {
        // Accept both to prevent any typo resolution errors
        return view('services.bank-asia.shonchoy-potros.show', compact('certificate'));
    }

    public function edit(BankAsiaShonchroPotro|BankAsiaShonchoyPotro $certificate): View
    {
        return view('services.bank-asia.shonchoy-potros.edit', compact('certificate'));
    }

    public function update(Request $request, BankAsiaShonchoyPotro $certificate): RedirectResponse
    {
        $validated = $request->validate([
            'purchaser_name' => 'required|string|max:255',
            'purchaser_nid' => 'required|string|max:30',
            'purchaser_phone' => 'required|string|max:20',
            'purchaser_dob' => 'required|date',
            'purchaser_address' => 'required|string',
            
            'certificate_type' => 'required|string|in:family,3_month_interest,pensioner,5_year_bd',
            'certificate_number' => 'required|string|max:100',
            'registration_number' => 'required|string|max:100',
            'purchase_date' => 'required|date',
            'maturity_date' => 'required|date|after_or_equal:purchase_date',
            'purchase_amount' => 'required|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            
            'nominee_name' => 'required|string|max:255',
            'nominee_relation' => 'required|string|max:100',
            'nominee_share_percent' => 'required|integer|min:1|max:100',
            
            'status' => 'required|string|in:active,matured,encashed',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        $data = $request->except(['document']);

        if ($request->hasFile('document')) {
            if ($certificate->document_path) {
                Storage::disk('public')->delete($certificate->document_path);
            }
            $path = $request->file('document')->store('bank-asia/shonchoy-potros', 'public');
            $data['document_path'] = $path;
        }

        $certificate->update($data);

        return redirect()->route('bank-asia.shonchoy-potros.show', $certificate)
            ->with('status', 'Savings certificate record updated successfully.');
    }

    public function destroy(BankAsiaShonchoyPotro $certificate): RedirectResponse
    {
        if ($certificate->document_path) {
            Storage::disk('public')->delete($certificate->document_path);
        }

        $certificate->delete();

        return redirect()->route('bank-asia.shonchoy-potros.index')
            ->with('status', 'Savings certificate record deleted successfully.');
    }
}
