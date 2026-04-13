<?php
namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\HipolabsService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(protected HipolabsService $hipolabs) {}

    public function index()
    {
        $registrations = Registration::latest()->get();
        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $universities = $this->hipolabs->search(country: 'Indonesia');
        return view('registrations.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:100',
            'email'             => 'required|email|unique:registrations',
            'phone'             => 'required|string|max:15',
            'birth_date'        => 'required|date',
            'gpa'               => 'required|numeric|min:0|max:4',
            'university_name'   => 'required|string',
            'university_domain' => 'required|string',
        ]);

        $validated['status'] = 'pending';
        Registration::create($validated);

        return redirect()->route('registrations.index')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $registration = Registration::findOrFail($id);
        $registration->update(['status' => $request->status]);

        return redirect()->route('registrations.index')
            ->with('success', 'Status pendaftaran diperbarui.');
    }

    public function destroy($id)
    {
        Registration::findOrFail($id)->delete();

        return redirect()->route('registrations.index')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
