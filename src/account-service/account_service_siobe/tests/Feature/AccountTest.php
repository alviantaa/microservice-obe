<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\StudentData;
use App\Models\User;

class AccountTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations, WithFaker;

    public function test_get_user_profiles_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $ids = "1-2-3";

        $response = $this->get('/profiles/'.$ids);

        $response->assertStatus(200)->assertJson([
            [
                'id' => 1,
                'name' => 'user1',
                'email' => 'user1@example.com',
                'role' => 'student',
                'student_id_number' => 'nimuser1',
            ],
            [
                'id' => 2,
                'name' => 'user2',
                'email' => 'user2@example.com',
                'role' => 'student',
                'student_id_number' => '',
            ],
            [
                'id' => 3,
                'status' => 'user not found'
            ],
        ]);
    }

    public function test_user_registration_is_successfull(): void
    {
        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $password = 'password';

        $response = $this->json('POST', '/api/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('status', '201 User successfully created')
                 ->where('email_to',$email)
                 ->has('link')->whereType('link','string')
        );

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function test_user_email_verification_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $response = $this->json('POST', '/api/auth/verify-email', [
            'token' => $token,
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('status', 'email verified')
        );
    }

    public function test_user_login_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('token_type','bearer')
                 ->where('expires_in',3600)
                 ->has('access_token')->whereType('access_token','string')
        );
    }

    public function test_user_update_profile_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);


        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $new_email = "user1_NewEmail@example.com";
        $new_name = "user1_NewName";
        $new_password = "asdf1234";
        $new_password_confirmation = "asdf1234";
        $student_id_number = "1122334455";

        $response = $this->json('POST', '/api/auth/profile', [
            'token' => $token,
            'password' => $password,
            'new_name' => $new_name,
            'email' => $new_email,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password_confirmation,
            'student_id_number' => $student_id_number,
        ]);
        
        $response ->assertJson([
            [
                'nim_update' => 'Success',
                'name_update' => 'Success',
                'password_update' => 'Success',
                'email_update' => 'Success',
                'email_to' => $new_email,
                'verification_link' => true,
            ]]);
    }
    public function test_user_forgot_password_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $response = $this->json('POST', '/api/auth/forgot-password', [
            'email' => $email,
        ]);

        $response->assertJson([
            'email_to' => $email,
            'link' => true,
        ]
        );
    }

    public function test_user_reset_password_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $new_password = "asdf1234";
        $new_password_confirmation = "asdf1234";

        $response = $this->json('POST', '/api/auth/reset-password', [
            'token' => $token,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password_confirmation,
        ]);

        $response->assertJson([
            'status' => "password changed successfully",
        ]
        );
    }

    public function test_user_delete_account_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $response = $this->json('DELETE', '/api/auth/delete-account/1', [
            'token' => $token,
        ]);

        $response->assertJson([
            'status' => "user successfully deleted",
        ]
        );
        $this->assertSoftDeleted($user);
    }

    public function test_me_token_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $response = $this->json('POST', '/api/auth/me', [
            'token' => $token,
        ]);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]
        );
    }

    public function test_logout_is_successfull(): void
    {
        $name = "user1";
        $email = "user1@example.com";
        $password = "asdfasdf";
        $role = "student";

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);
        StudentData::create([
            'id' => '1',
            'student_id_number' => 'nimuser1'
        ]);

        $userdb = User::find($user->id);
        $token = auth()->login($userdb);

        $response = $this->json('POST', '/api/auth/logout', [
            'token' => $token,
        ]);

        $response->assertJson([
            'status' => "Successfully logged out",
        ]
        );
    }
}
