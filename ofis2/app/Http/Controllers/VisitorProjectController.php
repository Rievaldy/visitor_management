<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VisitorProjectController extends Controller
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
        $data = DB::table('visitor_project')->
        join('visitor', 'visitor.id', '=', 'visitor_project.id_visitor')->
        join('project', 'project.id', '=', 'visitor_project.id_project')->
        select('visitor_project.id as id', 'project.id as project_id', 'visitor.id as visitor_id', 'visitor.name as visitor_name', 'visitor.email as visitor_email', 'visitor_project.level as visitor_level', 'visitor.ktp as visitor_ktp')->
        where('visitor_project.id_project', '=', $id)->get();
        
        return response()->json($data);
    }
}
