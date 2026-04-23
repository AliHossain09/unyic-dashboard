<?php

namespace Tests\Feature;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_addresses_in_expected_format(): void
    {
        $first = Address::create([
            'name' => 'Rownok Zahan',
            'email' => 'rownok.zahan@gmail.com',
            'phone' => '+8801701122334',
            'address' => 'Flat 4B, House 23, Road 7, Dhanmondi, Dhaka',
            'address_type' => 'Home',
            'is_default' => true,
            'is_selected' => true,
            'guest_token' => 'guest-token-1234567890123456789012345678901234567890',
        ]);

        Address::create([
            'name' => 'Rownok Zahan',
            'email' => 'rzahan.office@techmail.com',
            'phone' => '+8801804455667',
            'address' => 'Level 9, Software Park, Kawran Bazar, Dhaka',
            'address_type' => 'Work',
            'is_default' => false,
            'is_selected' => false,
            'guest_token' => $first->guest_token,
        ]);

        $response = $this
            ->withCookie('guest_token', $first->guest_token)
            ->getJson('/api/addresses');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Addresses fetched successfully',
            ])
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'Rownok Zahan')
            ->assertJsonPath('data.0.addressType', 'Work')
            ->assertJsonPath('data.0.isDefault', false)
            ->assertJsonPath('data.0.isSelected', false)
            ->assertJsonPath('data.1.addressType', 'Home')
            ->assertJsonPath('data.1.isDefault', true)
            ->assertJsonPath('data.1.isSelected', true);
    }

    public function test_it_creates_the_first_address_as_selected(): void
    {
        $response = $this->postJson('/api/addresses', [
            'name' => 'Ali Hossain',
            'email' => 'ali@example.com',
            'phone' => '+8801612233445',
            'address' => 'Village: Kaliganj Bazar, Gazipur',
            'addressType' => 'Home',
            'isDefault' => false,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'status' => 201,
                'message' => 'Address created successfully',
            ]);

        $this->assertDatabaseHas('addresses', [
            'email' => 'ali@example.com',
            'is_default' => false,
            'is_selected' => true,
        ]);
    }

    public function test_it_updates_selected_address(): void
    {
        $guestToken = 'guest-token-abcdefghijklmnopqrstuvwxyz12345678901234567890';

        $first = Address::create([
            'name' => 'Rownok Zahan',
            'email' => 'one@example.com',
            'phone' => '+8801701122334',
            'address' => 'Dhaka',
            'address_type' => 'Home',
            'is_default' => true,
            'is_selected' => true,
            'guest_token' => $guestToken,
        ]);

        $second = Address::create([
            'name' => 'Ali Hossain',
            'email' => 'two@example.com',
            'phone' => '+8801804455667',
            'address' => 'Gazipur',
            'address_type' => 'Work',
            'is_default' => false,
            'is_selected' => false,
            'guest_token' => $guestToken,
        ]);

        $response = $this
            ->withCookie('guest_token', $guestToken)
            ->patchJson('/api/addresses/selected-address', [
                'addressId' => $second->id,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'status' => 200,
                'message' => 'Selected address updated',
            ]);

        $this->assertDatabaseHas('addresses', [
            'id' => $first->id,
            'is_selected' => false,
        ]);

        $this->assertDatabaseHas('addresses', [
            'id' => $second->id,
            'is_selected' => true,
        ]);
    }

    public function test_it_falls_back_to_latest_address_when_selected_one_is_deleted(): void
    {
        $guestToken = 'guest-token-delete-fallback-1234567890123456789012345678901234';

        $selected = Address::create([
            'name' => 'Selected Address',
            'email' => 'selected@example.com',
            'phone' => '+8801700000001',
            'address' => 'Old Address',
            'address_type' => 'Home',
            'is_default' => false,
            'is_selected' => true,
            'guest_token' => $guestToken,
        ]);

        $latest = Address::create([
            'name' => 'Latest Address',
            'email' => 'latest@example.com',
            'phone' => '+8801700000002',
            'address' => 'New Address',
            'address_type' => 'Work',
            'is_default' => false,
            'is_selected' => false,
            'guest_token' => $guestToken,
        ]);

        $this->withCookie('guest_token', $guestToken)
            ->deleteJson("/api/addresses/{$selected->id}")
            ->assertOk()
            ->assertJson([
                'success' => true,
                'status' => 200,
                'message' => 'Address deleted successfully',
            ]);

        $this->assertDatabaseMissing('addresses', ['id' => $selected->id]);
        $this->assertDatabaseHas('addresses', [
            'id' => $latest->id,
            'is_selected' => true,
        ]);
    }

    public function test_it_returns_validation_errors_in_documented_shape(): void
    {
        $response = $this->postJson('/api/addresses', []);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'status' => 400,
                'message' => 'Validation failed',
            ])
            ->assertJsonFragment(['Name is required'])
            ->assertJsonFragment(['Email is required'])
            ->assertJsonFragment(['Phone is required']);
    }
}
