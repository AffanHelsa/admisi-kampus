<?php
use App\Models\Registration;
use App\Services\HipolabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/universities/search', function (Request $request) {
    $service = app(HipolabsService::class);
    $data    = $service->search(
        $request->query('name'),
        $request->query('country', 'Indonesia')
    );
    return response()->json([
        'status' => 'success',
        'total'  => count($data),
        'data'   => $data,
    ]);
});

Route::get('/registrations', fn() =>
    response()->json(Registration::latest()->get())
);

Route::post('/registrations', function (Request $request) {
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
    return response()->json(Registration::create($validated), 201);
});

Route::put('/registrations/{id}', function (Request $request, $id) {
    $reg = Registration::findOrFail($id);
    $reg->update($request->only('status'));
    return response()->json($reg);
});

Route::delete('/registrations/{id}', function ($id) {
    Registration::findOrFail($id)->delete();
    return response()->json(['message' => 'Pendaftaran berhasil dibatalkan']);
});
