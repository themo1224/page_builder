<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase; // This trait rolls back database changes after each test, ensuring a fresh state.

    /**
     * Test successful user registration.
     */
    public function test_user_can_register(): void // Defines a test method for user registration.
    {
        $response = $this->postJson('/api/auth/register', [ // Sends a POST request to the registration endpoint.
            'name' => 'Test User', // Sets the name attribute to simulate user input.
            'email' => 'test@example.com', // Sets the email attribute.
            'password' => 'password', // Sets the password.
        ]);

        $response->assertStatus(201) // Asserts that the HTTP status code is 201 (Created).
            ->assertJsonStructure(['token', 'message']); // Checks that the JSON response includes 'token' and 'message' keys.

        $this->assertDatabaseHas('users', [ // Checks that the users table has a record with the following data.
            'email' => 'test@example.com', // Verifies that the email was saved correctly.
        ]);
    }

    /**
     * Test registration fails due to validation errors.
     */
    public function test_registration_fails_with_validation_errors(): void // Defines a test for failed registration.
    {
        $response = $this->postJson('/api/auth/register', [ // Sends a POST request with invalid data.
            'name' => '', // Empty name should trigger a validation error.
            'email' => 'not-an-email', // Invalid email format.
            'password' => 'short', // Too short to pass password validation.
        ]);

        $response->assertStatus(422) // Asserts that the HTTP status code is 422 (Unprocessable Entity).
            ->assertJsonValidationErrors(['name', 'email', 'password']); // Checks for validation error messages for these fields.
    }

    // /**
    //  * Test successful user login.
    //  */
    public function test_user_can_login(): void // Defines a test for successful login.
    {
        // Create a user first
        $user = User::factory()->create([ // Uses a factory to create a user with specific attributes.
            'email' => 'test@example.com', // Sets the user's email.
            'password' => bcrypt('password'), // Encrypts the password so it matches the login credentials.
        ]);

        $response = $this->postJson('/api/auth/login', [ // Sends a POST request to the login endpoint.
            'email' => 'test@example.com', // Supplies the email to log in.
            'password' => 'password', // Supplies the password to log in.
        ]);

        $response->assertStatus(200) // Asserts that the HTTP status code is 200 (OK).
            ->assertJsonStructure(['token', 'message']); // Checks that the JSON response includes 'token' and 'message' keys.
    }

    // /**
    //  * Test login fails with incorrect credentials.
    //  */
    // public function test_login_fails_with_incorrect_credentials(): void // Defines a test for failed login.
    // {
    //     // Create a user first
    //     $user = User::factory()->create([ // Creates a user with specific credentials.
    //         'email' => 'test@example.com', // Sets the user's email.
    //         'password' => bcrypt('password'), // Encrypts the password.
    //     ]);

    //     $response = $this->postJson('/api/auth/login', [ // Sends a POST request to login with incorrect credentials.
    //         'email' => 'test@example.com', // Provides the correct email.
    //         'password' => 'wrongpassword', // Provides an incorrect password.
    //     ]);

    //     $response->assertStatus(401) // Asserts that the HTTP status code is 401 (Unauthorized).
    //         ->assertJson(['message' => 'Invalid credentials']); // Verifies that the response has the expected error message.
    // }

    // /**
    //  * Test successful logout.
    //  */
    // public function test_user_can_logout(): void // Defines a test for successful logout.
    // {
    //     // Create a user and log in to obtain a token
    //     $user = User::factory()->create(); // Creates a user.
    //     $token = $user->createToken('auth_token')->plainTextToken; // Generates an auth token for the user.

    //     $response = $this->withHeader('Authorization', 'Bearer ' . $token) // Adds the token to the Authorization header.
    //         ->postJson('/api/auth/logout'); // Sends a POST request to the logout endpoint.

    //     $response->assertStatus(200) // Asserts that the HTTP status code is 200 (OK).
    //         ->assertJson(['message' => 'Logged out successfully']); // Checks that the response contains the logout success message.
    // }
}
