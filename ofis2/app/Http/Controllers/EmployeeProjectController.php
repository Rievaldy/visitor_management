<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EmployeeProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByIdProject($id)
    {
        $data = DB::table('employee_project')->
        join('users', 'users.id', '=', 'employee_project.id_user')->
        join('project', 'project.id', '=', 'employee_project.id_project')->
        select('employee_project.id as id', 'project.id as project_id', 'users.id as employee_id', 'users.name as employee_name', 'users.email as employee_email', 'employee_project.level as employee_level')->
        where('employee_project.id_project', '=', $id)->get();

        return response()->json($data);
    }

    public function showByIdEmployee($id)
    {
        $data = DB::table('employee_project')->
        join('users', 'users.id', '=', 'employee_project.id_user')->
        join('project', 'project.id', '=', 'employee_project.id_project')->
        select('employee_project.id as id', 'project.id as project_id', 'users.id as employee_id', 'project.name as project_name', 'project.email as employee_email', 'employee_project.level as employee_level')->
        where('employee_project.id_project', '=', $id)->get();

        return response()->json($data);
    }
}
