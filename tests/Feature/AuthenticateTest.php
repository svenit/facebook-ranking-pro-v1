<?php

namespace Tests\Feature;

use App\Model\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp() :void
    {
        $this->user = factory(User::class)->create();
    }

    public function testUserLogined()
    {
        $this->visit('/')->seePageIs('/');
    }
}
