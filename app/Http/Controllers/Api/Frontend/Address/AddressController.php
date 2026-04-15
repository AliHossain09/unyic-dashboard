<?php

namespace App\Http\Controllers\Api\Frontend\Address;

use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index()
    {
        try {
            $addresses = collect([
                [
                    'id' => 1,
                    'name' => 'Rownok Zahan',
                    'email' => 'rownok.zahan@gmail.com',
                    'phone' => '+8801701122334',
                    'address' => 'Flat 4B, House 23, Road 7, Dhanmondi, Dhaka',
                    'addressType' => 'Home',
                    'isDefaultAddress' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Rownok Zahan',
                    'email' => 'rzahan.office@techmail.com',
                    'phone' => '+8801804455667',
                    'address' => 'Level 9, Software Park, Kawran Bazar, Dhaka',
                    'addressType' => 'Work',
                    'isDefaultAddress' => false,
                ],
                [
                    'id' => 3,
                    'name' => 'Ali Hossain',
                    'email' => 'hossain.family@outlook.com',
                    'phone' => '+8801612233445',
                    'address' => 'Village: Kaliganj Bazar, Gazipur',
                    'addressType' => 'Family',
                    'isDefaultAddress' => false,
                ],
            ])->values();

            return response()->json([
                'success' => true,
                'message' => 'Addresses fetched successfully',
                'data' => $addresses,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch addresses',
            ], 500);
        }
    }
}
