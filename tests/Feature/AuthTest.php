<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Testing Validation for User Registration: api/v1/register
     */
    public function testValidationForRegistration()
    {
        $this->json('POST', 'api/v1/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Validation failed.",
                "data" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                    "device_name" => ["The device name field is required."],
                ]
            ]);
    }


    /**
     * Testing Successful User Registration feature: api/v1/register
     */
    public function testSuccessfulUserRegistration()
    {
        $userData = [
            "name" => "John Cena",
            "email" => "john".time()."@test.com",
            "password" => "test1234",
            "device_name" => "testing"
        ];

        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "token",
                    "user" => [
                        "id",
                        "name",
                        "email"
                    ]
                ],
                "code",
                "message"
            ]);

            $this->assertDatabaseHas('users', [
                'email' => $userData['email'],
            ]);
    }


    /**
     * Testing Validation for User Login: api/v1/login
     */
    public function testValidationForLogin()
    {
        $this->json('POST', 'api/v1/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Validation failed.",
                "data" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                    "device_name" => ["The device name field is required."],
                ]
            ]);
    }


    /**
     * Testing Invalid Credentials for User Login: api/v1/login
     */
    public function testInvalidCredentialsForLogin()
    {
        $userData = [
            "email" => "user1@test.com",
            "password" => "wrongpassword",
            "device_name" => "testing"
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Invalid Credentials",
                "code" => 422
            ]);
    }


    /**
     * Testing Succesful User Login feature: api/v1/login
     */
    public function testSuccessfulUserLogin()
    {
        $userData = [
            "email" => "user1@test.com",
            "password" => "test123",
            "device_name" => "testing"
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "token",
                    "user" => [
                        "id",
                        "name",
                        "email"
                    ]
                ],
                "code",
                "message"
            ]);
    }
}
