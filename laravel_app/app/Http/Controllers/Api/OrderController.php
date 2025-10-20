<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with(['driver', 'user'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn (Order $order) => $this->formatOrder($order));

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    public function indexAdmin(Request $request): JsonResponse
    {
        $query = Order::with(['driver', 'user']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('from_address', 'like', "%{$search}%")
                    ->orWhere('to_address', 'like', "%{$search}%")
                    ->orWhere('car_type', 'like', "%{$search}%")
                    ->orWhereHas('driver', fn ($driverQuery) => $driverQuery->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $sortField = $request->input('sortField', 'id');
        $sortOrder = $request->input('sortOrder', 'desc');

        $allowedSortFields = ['id', 'from_address', 'to_address', 'car_type', 'price', 'distance'];
        if (!in_array($sortField, $allowedSortFields, true)) {
            $sortField = 'id';
        }
        if (!in_array($sortOrder, ['asc', 'desc'], true)) {
            $sortOrder = 'desc';
        }

        $orders = $query
            ->orderBy($sortField, $sortOrder)
            ->get()
            ->map(fn (Order $order) => $this->formatOrder($order));

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $validated = $request->validate([
            'from_address' => ['required', 'string', 'max:255'],
            'to_address' => ['required', 'string', 'max:255'],
            'car_type' => ['required', 'string', 'max:50'],
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'distance' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['user_id'] = $request->user()->id;

        $order = Order::create($validated)->load(['driver', 'user']);

        return response()->json([
            'success' => true,
            'order' => $this->formatOrder($order),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::with(['driver', 'user'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $this->formatOrder($order),
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $validated = $request->validate([
            'from_address' => ['sometimes', 'string', 'max:255'],
            'to_address' => ['sometimes', 'string', 'max:255'],
            'car_type' => ['sometimes', 'string', 'max:50'],
            'driver_id' => ['sometimes', 'integer', 'exists:drivers,id'],
            'distance' => ['sometimes', 'numeric', 'min:0'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'max:50'],
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'order' => $this->formatOrder($order->load(['driver', 'user'])),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted',
        ]);
    }

    private function formatOrder(Order $order): array
    {
        return [
            'id' => $order->id,
            'from_address' => $order->from_address,
            'to_address' => $order->to_address,
            'car_type' => $order->car_type,
            'status' => $order->status,
            'driver' => $order->driver ? [
                'id' => $order->driver->id,
                'name' => $order->driver->name,
                'phone' => $order->driver->phone,
            ] : null,
            'user' => $order->user ? [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
            ] : null,
            'distance' => $order->distance,
            'price' => $order->price,
            'created_at' => optional($order->created_at)->toDateTimeString(),
        ];
    }
}
