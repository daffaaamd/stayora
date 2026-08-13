<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this
            ->actingAs($user)
            ->get(route('customer.profile'));

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this
            ->actingAs($user)
            ->put(route('customer.profile.update'), [
                'name' => 'Updated Guest Name',
                'phone' => '+62 812-9988-7766',
                'address' => 'Jakarta, Indonesia',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('customer.profile'));

        $user->refresh();

        $this->assertSame('Updated Guest Name', $user->name);
        $this->assertSame('+62 812-9988-7766', $user->phone);
    }
}
