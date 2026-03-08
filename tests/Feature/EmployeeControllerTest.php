<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_view_employee_index()
    {
        $admin = User::factory()->create();
        Employee::factory(5)->create();

        $response = $this->actingAs($admin)->get(route('employees.index'));

        $response->assertStatus(200);
        $response->assertViewIs('employees.index');
        $response->assertViewHas('employees');
    }

    public function test_admin_can_view_create_employee_form()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('employees.create'));

        $response->assertStatus(200);
        $response->assertViewIs('employees.create');
    }

    public function test_admin_can_store_new_employee()
    {
        $admin = User::factory()->create();

        $employeeData = [
            'name' => 'John',
            'surname' => 'Doe',
            'birthday' => '1990-01-01',
            'birthplace' => 'New York',
            'gender' => 'men',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'department' => 'Engineering',
            'position' => 'Developer',
            'address' => '123 Tech St',
            'state' => 'NY',
        ];

        $response = $this->actingAs($admin)->post(route('employees.store'), $employeeData);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', ['email' => 'john.doe@example.com']);
    }

    public function test_admin_can_view_employee_details()
    {
        $admin = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($admin)->get(route('employees.show', $employee));

        $response->assertStatus(200);
        $response->assertViewIs('employees.show');
        $response->assertViewHas('employee', $employee);
    }

    public function test_admin_can_view_edit_employee_form()
    {
        $admin = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($admin)->get(route('employees.edit', $employee));

        $response->assertStatus(200);
        $response->assertViewIs('employees.edit');
        $response->assertViewHas('employee', $employee);
    }

    public function test_admin_can_update_employee()
    {
        $admin = User::factory()->create();
        $employee = Employee::factory()->create();

        $updatedData = [
            'name' => 'Jane',
            'surname' => 'Smith',
            'birthday' => $employee->birthday,
            'birthplace' => $employee->birthplace,
            'gender' => 'women',
            'email' => 'jane.smith@example.com',
            'phone' => $employee->phone,
            'department' => $employee->department,
            'position' => $employee->position,
            'address' => $employee->address,
            'state' => $employee->state,
        ];

        $response = $this->actingAs($admin)->put(route('employees.update', $employee), $updatedData);

        $response->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'email' => 'jane.smith@example.com',
            'name' => 'Jane'
        ]);
    }

    public function test_admin_can_delete_employee()
    {
        $admin = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($admin)->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'));
        $this->assertSoftDeleted('employees', ['id' => $employee->id]);
    }
}
