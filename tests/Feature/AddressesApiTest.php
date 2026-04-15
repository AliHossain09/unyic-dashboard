<?php

namespace Tests\Feature;

use Tests\TestCase;

class AddressesApiTest extends TestCase
{
    public function test_it_returns_addresses_in_expected_format(): void
    {
        $response = $this->getJson('/api/addresses');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Addresses fetched successfully',
            ])
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.name', 'Rownok Zahan')
            ->assertJsonPath('data.0.addressType', 'Home')
            ->assertJsonPath('data.0.isDefaultAddress', true)
            ->assertJsonPath('data.2.id', 3)
            ->assertJsonPath('data.2.name', 'Ali Hossain')
            ->assertJsonPath('data.2.addressType', 'Family')
            ->assertJsonPath('data.2.isDefaultAddress', false);
    }
}
