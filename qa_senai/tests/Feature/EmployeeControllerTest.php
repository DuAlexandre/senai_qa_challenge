<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    /**
     * Reinitializes the database after every test
     */
    use RefreshDatabase;

    public function test_Get_All_Employees_Endpoint(): void
    {
        Department::factory(6)->create();
        $employee = Employee::factory(3)->create();
        $response = $this->getJson('/api/employees');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use($employee){
            $json->whereAllType([
                '0.id'               => 'integer',
                '0.name'             => 'string',
                '0.email'            => 'string',
                '0.phone'            => 'string',
                '0.department_id'    => 'integer'
            ]);

            $json->hasAll(
                [
                    '0.id',
                    '0.name',
                    '0.email',
                    '0.phone',
                    '0.department_id'
                ]);

            $employee = $employee->first();

            $json->whereAll([
                '0.id'               => $employee->id,
                '0.name'             => $employee->name,
                '0.email'            => $employee->email,
                '0.phone'            => $employee->phone,
                '0.department_id'    => $employee->department_id
            ]);
        });
    }


    public function test_Get_Single_Employee_Endpoint()
    {
        Department::factory(6)->create();
        $employee = Employee::factory(1)->createOne();
        $response = $this->getJson('/api/employees/' . $employee->id );
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($employee){
            
            $json->hasAll(
                [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'department_id',
                    'created_at',
                    'updated_at'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string',
                    'email'         => 'string',
                    'phone'         => 'string',
                    'department_id' => 'integer'
                ]);

                $json->whereAll([
                    'id'            => $employee->id,
                    'name'          => $employee->name,
                    'email'         => $employee->email,
                    'phone'         => $employee->phone,
                    'department_id' => $employee->department_id
                ]);
        });
    }


    public function test_Post_Employee_Endpoint()
    {
        Department::factory(6)->create();
        $employee = Employee::factory(1)->makeOne()->toArray(); 
        $response = $this->postJson('/api/employees', $employee);
        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use($employee){
            $json->hasAll(
                [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'department_id',
                    'created_at',
                    'updated_at'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string',
                    'email'         => 'string',
                    'phone'         => 'string',
                    'department_id' => 'integer'
                ]);

                $json->whereAll([
                    'name'          => $employee['name'],
                    'email'         => $employee['email'],
                    'phone'         => $employee['phone'],
                    'department_id' => $employee['department_id']
                ])->etc();

        });
    }


    public function test_Put_Employee_Endpoint()
    {
        Department::factory(6)->create();
        Employee::factory(1)->createOne();

        $employee = 
        [
            'name' => 'Mock Response',
            'email' => 'mock@email.com',
            'phone' => '9999999999',
            'department_id' => 1
        ];
        $response = $this->putJson('/api/employees/1', $employee);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($employee){
            $json->hasAll(
                [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'department_id',
                    'created_at',
                    'updated_at'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string',
                    'email'         => 'string',
                    'phone'         => 'string',
                    'department_id' => 'integer'
                ]);

                $json->whereAll([
                    'name'          => $employee['name'],
                    'email'         => $employee['email'],
                    'phone'         => $employee['phone'],
                    'department_id' => $employee['department_id']
                ])->etc();

        });
    }
}
