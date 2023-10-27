<?php

namespace Tests\Feature;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_finds_register_user_route()
    {
        // Arrange
        $params = [
            'name'      => 'John Doe',
            'email'     => 'jdow@gmail.com',
            'password'  => '1234567',
        ];

        // Act, Assert
        $this->postJson('/api/v1/auth/register', $params)
            ->assertOk();
    }

    /** @test */
    public function it_register_user_successfully_in_database()
    {
        // Arrange
        $params = [
            'name'      => 'John Doe',
            'email'     => 'jdow@gmail.com',
            'password'  => '1234567',
        ];

        // Act
        $response = $this->postJson('/api/v1/auth/register', $params)
            ->assertOk();

        $userId = data_get($response->json(), 'user.id');


        // Assert
        $response->assertSimilarJson([
            'message'   => 'User registered successfully',
            'user'      => [
                'id'    => $userId,
                'name'  => $params['name'],
                'email' => $params['email'],
            ],
        ]);


        $user = User::where('email', $params['email'])->first();
        $this->assertNotNull($user);
        $this->assertEquals($params['name'], $user->name);
        $this->assertTrue(Hash::check($params['password'], $user->password));
    }

    /** @test */
    public function it_returns_registration_error_when_validation_fail()
    {
        // Arrange
        $params = [
            'email'     => 'jdow@gmail.com',
            'password'  => '1234567',
        ];

        // Act
        $request = new RegisterUserRequest();

        $validator = Validator::make($params, $request->rules(), $request->messages());


        // Assert
        $this->assertFalse($validator->passes());
    }

    /** @test */
    public function it_finds_login_user_route()
    {
        // Arrange
        $params = [
            'email'     => 'jdow@gmail.com',
            'password'  => '1234567',
        ];

        // Act, Assert
        $this->postJson('/api/v1/auth/login', $params)
            ->assertUnauthorized();
    }

    /** @test */
    public function it_login_user_successfully()
    {
        // Arrange
        $user = User::factory()->create([
            'email'     => 'jdow@gmail.com',
            'password'  => bcrypt('1234567')
        ]);

        $params = [
            'email'     => 'jdow@gmail.com',
            'password'  => '1234567',
        ];

        // Act, Assert
        $response = $this->postJson('/api/v1/auth/login', $params)
            ->assertOk();


        // Assert
        $response->assertJsonFragment([
            'message'   => 'User logged in successfully',
            'user'      => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
