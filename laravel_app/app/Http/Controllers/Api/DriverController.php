<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Driver::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $drivers = $query
            ->orderBy('name')
            ->get()
            ->map(fn (Driver $driver) => $this->formatDriver($driver));

        return response()->json([
            'success' => true,
            'drivers' => $drivers,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'driver' => $this->formatDriver($driver),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:free,busy'],
            'car_type' => ['required', 'string', 'max:100'],
        ]);

        $driver = Driver::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Driver created successfully',
            'driver' => $this->formatDriver($driver),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20'],
            'experience_years' => ['sometimes', 'integer', 'min:0'],
            'photo' => ['nullable', 'string'],
            'status' => ['sometimes', 'string', 'in:free,busy'],
            'car_type' => ['sometimes', 'string', 'max:100'],
        ]);

        $driver->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Driver updated successfully',
            'driver' => $this->formatDriver($driver),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found',
            ], 404);
        }

        $driver->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver deleted successfully',
        ]);
    }

    private function formatDriver(Driver $driver): array
    {
        return [
            'id' => $driver->id,
            'name' => $driver->name,
            'phone' => $driver->phone,
            'experience_years' => $driver->experience_years,
            'photo' => $driver->photo,
            'status' => $driver->status,
            'car_type' => $driver->car_type,
        ];
    }
}
