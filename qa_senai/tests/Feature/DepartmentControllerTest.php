<?php

namespace Tests\Feature;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    /**
     * Reinitializes the database after every test
     */
    use RefreshDatabase;

    public function test_Get_All_Departments_Endpoint(): void
    {
        $department = Department::factory(3)->create();
        $response = $this->getJson('/api/departments');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use($department){
            $json->whereAllType([
                '0.id'               => 'integer',
                '0.name'             => 'string'
            ]);

            $json->hasAll(
                [
                    '0.id',
                    '0.name'
                ]);

            $department = $department->first();

            $json->whereAll([
                '0.id'               => $department->id,
                '0.name'             => $department->name
            ]);
        });
    }


    public function test_Get_Single_Department_Endpoint()
    {
        $department = Department::factory(1)->createOne();
        $response = $this->getJson('/api/departments/' . $department->id );
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($department){
            
            $json->hasAll(
                [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string'
                ]);

                $json->whereAll([
                    'id'            => $department->id,
                    'name'          => $department->name
                ]);
        });
    }


    public function test_Post_Department_Endpoint()
    {
        $department = Department::factory(1)->makeOne()->toArray();    
        $response = $this->postJson('/api/departments', $department);
        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use($department){
            $json->hasAll(
                [
                    'id',
                    'name'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string'
                ]);

                $json->whereAll([
                    'name'          => $department['name']
                ])->etc();

        });
    }


    public function test_Put_Department_Endpoint()
    {
        Department::factory(1)->createOne();
        $department =
        [
            'name' => 'Mock Response'
        ];

        $response = $this->putJson('/api/departments/1', $department);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($department){
            $json->hasAll(
                [
                    'id',
                    'name'
                ]);

                $json->whereAllType([
                    'id'            => 'integer',
                    'name'          => 'string'
                ]);

                $json->whereAll([
                    'name'          => $department['name']
                ])->etc();

        });
    }
}
