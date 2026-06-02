<?php

namespace Tests\Feature;

use App\Models\CreativeType;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllersTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+1234567890',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_leader_cabinet_is_accessible_by_leader()
    {
        $leader = User::factory()->create(['role' => 'leader']);

        $response = $this->actingAs($leader)->get('/cabinet');
        $response->assertStatus(200);
    }

    public function test_creative_type_page_is_accessible()
    {
        $creativeType = CreativeType::create([
            'name' => 'Test Type',
            'slug' => 'test-type',
            'description' => 'Test description'
        ]);

        $response = $this->get('/creative-types/' . $creativeType->slug);
        $response->assertStatus(200);
    }

    public function test_leader_can_create_master_class()
    {
        $leader = User::factory()->create(['role' => 'leader']);
        $creativeType = CreativeType::create([
            'name' => 'Test Type 2',
            'slug' => 'test-type-2',
            'description' => 'Test description'
        ]);

        $response = $this->actingAs($leader)->post('/master-classes', [
            'creative_type_id' => $creativeType->id,
            'title' => 'Test Master Class Title',
            'description' => 'Test Master Class Description with more than 20 characters',
            'session_date' => now()->addDay()->format('Y-m-d'),
            'slot_time' => '13:00:00',
            'max_participants' => 10,
            'price' => 100.50,
        ]);

        $response->assertRedirect('/cabinet');
        $this->assertDatabaseHas('master_classes', [
            'title' => 'Test Master Class Title',
        ]);
    }
}
