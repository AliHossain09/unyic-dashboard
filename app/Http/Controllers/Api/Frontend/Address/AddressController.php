<?php

namespace App\Http\Controllers\Api\Frontend\Address;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Support\GuestCookie;
use App\Support\ShoppingIdentity;
use App\Support\ShoppingScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $identity = ShoppingIdentity::resolve($request);

            $addresses = $this->addressListingQuery($identity)->get();

            ShoppingScope::touchGuestItems(Address::class, $identity);

            return $this->withGuestCookie($identity, response()->json([
                'success' => true,
                'message' => 'Addresses fetched successfully',
                'data' => $this->transformAddresses($addresses),
            ]));
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Failed to fetch addresses',
                'errors' => ['Internal server error'],
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return $this->validationResponse($validator->errors()->all());
        }

        $identity = ShoppingIdentity::resolve($request);
        $payload = $validator->validated();
        $isDefault = (bool) ($payload['isDefault'] ?? false);

        $existingAddresses = $this->addressListingQuery($identity)->get();
        $shouldSelect = $isDefault || $existingAddresses->isEmpty();

        if ($isDefault) {
            $this->clearDefaultFlags($identity);
        }

        if ($shouldSelect) {
            $this->clearSelectedFlags($identity);
        }

        Address::create([
            'user_id' => $identity['user_id'],
            'guest_token' => $identity['guest_token'],
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'address' => $payload['address'],
            'address_type' => $payload['addressType'],
            'is_default' => $isDefault,
            'is_selected' => $shouldSelect,
            ...ShoppingScope::guestActivityPayload($identity),
        ]);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'status' => 201,
            'message' => 'Address created successfully',
        ], 201));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return $this->validationResponse($validator->errors()->all());
        }

        $identity = ShoppingIdentity::resolve($request);
        $address = $this->scopedQuery($identity)->where('id', $id)->first();

        if (! $address) {
            return $this->notFoundResponse();
        }

        $payload = $validator->validated();
        $isDefault = (bool) ($payload['isDefault'] ?? false);

        if ($isDefault) {
            $this->clearDefaultFlags($identity, $address->id);
        }

        if ($address->is_selected || $isDefault) {
            $this->clearSelectedFlags($identity, $address->id);
        }

        $address->update([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'address' => $payload['address'],
            'address_type' => $payload['addressType'],
            'is_default' => $isDefault,
            'is_selected' => $address->is_selected || $isDefault,
            ...ShoppingScope::guestActivityPayload($identity),
        ]);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Address updated successfully',
        ]));
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $identity = ShoppingIdentity::resolve($request);
        $address = $this->scopedQuery($identity)->where('id', $id)->first();

        if (! $address) {
            return $this->notFoundResponse();
        }

        $wasSelected = $address->is_selected;
        $address->delete();

        if ($wasSelected) {
            $this->selectFallbackAddress($identity);
        }

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Address deleted successfully',
        ]));
    }

    public function setSelectedAddress(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'addressId' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Invalid address ID',
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $identity = ShoppingIdentity::resolve($request);
        $address = $this->scopedQuery($identity)
            ->where('id', $request->integer('addressId'))
            ->first();

        if (! $address) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Invalid address ID',
                'errors' => ['Address does not exist'],
            ], 400);
        }

        $this->clearSelectedFlags($identity);

        $address->update([
            'is_selected' => true,
            ...ShoppingScope::guestActivityPayload($identity),
        ]);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Selected address updated',
        ]));
    }

    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'addressType' => ['required', 'string', 'max:50'],
            'isDefault' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'addressType.required' => 'Address type is required',
        ]);
    }

    protected function scopedQuery(array $identity)
    {
        return ShoppingScope::apply(Address::query(), $identity);
    }

    protected function addressListingQuery(array $identity)
    {
        return $this->scopedQuery($identity)
            ->latest()
            ->latest('id');
    }

    protected function transformAddresses($addresses): array
    {
        $selectedId = optional($addresses->firstWhere('is_selected', true))->id;

        if (! $selectedId) {
            $selectedId = optional($addresses->sortByDesc('id')->first())->id;
        }

        return $addresses->map(function (Address $address) use ($selectedId) {
            return [
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'addressType' => $address->address_type,
                'isDefault' => (bool) $address->is_default,
                'isSelected' => $address->id === $selectedId,
            ];
        })->values()->all();
    }

    protected function clearDefaultFlags(array $identity, ?int $exceptId = null): void
    {
        $query = $this->scopedQuery($identity)->where('is_default', true);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $query->update(['is_default' => false]);
    }

    protected function clearSelectedFlags(array $identity, ?int $exceptId = null): void
    {
        $query = $this->scopedQuery($identity)->where('is_selected', true);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $query->update(['is_selected' => false]);
    }

    protected function selectFallbackAddress(array $identity): void
    {
        $fallback = $this->scopedQuery($identity)
            ->orderByDesc('is_default')
            ->orderByDesc('is_selected')
            ->orderByDesc('id')
            ->first();

        if (! $fallback) {
            return;
        }

        $this->clearSelectedFlags($identity, $fallback->id);

        $fallback->update([
            'is_selected' => true,
            ...ShoppingScope::guestActivityPayload($identity),
        ]);
    }

    protected function validationResponse(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 400,
            'message' => 'Validation failed',
            'errors' => $errors,
        ], 400);
    }

    protected function notFoundResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 404,
            'message' => 'Address not found',
            'errors' => ['Invalid address ID'],
        ], 404);
    }

    protected function withGuestCookie(array $identity, JsonResponse $response): JsonResponse
    {
        if ($identity['type'] === 'guest' && $identity['guest_token']) {
            $response->cookie(GuestCookie::make($identity['guest_token']));
        }

        return $response;
    }
}
