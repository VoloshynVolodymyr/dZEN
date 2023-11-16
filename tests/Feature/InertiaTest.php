<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Inertia\Testing\Assert;

class InertiaTest extends TestCase
{
    public function test_users_index_component()
    {
        $this->get('/users')
            ->assertInertia(function (Assert $page) {
                $page->component('Users/Index')
                    ->has('users')
                    ->has('title')
                    ->where('title', 'Users')
                    ->has('users.data')
                    ->has('users.links')
                ;
            });
    }

    public function test_add_user_component()
    {
        $this->get('/users/create')
            ->assertInertia(function (Assert $page) {
                $page->component('Users/Create')
                    ->has('title')
                    ->where('title', 'Users');
            })
            ->assertStatus(200);
    }

    public function test_can_show_user_edit_component()
    {
        $user = User::factory()->create();

        $this->get("/users/{$user->id}/edit")
            ->assertInertia(function (Assert $page) use ($user) {
                $page->component('Users/Edit')
                    ->has('user')
                    ->has('title')
                    ->where('title', 'Edit user');
            })
            ->assertStatus(200);
    }



}
