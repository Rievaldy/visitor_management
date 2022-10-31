<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
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
        $visitor = Visitor::find($id);
        return response()->json($visitor);
    }

    public function getVisitorSelect2(Request $request){
        $list = DB::select("SELECT
                id AS id, name AS text
            FROM
                visitor WHERE id_company = ".+$request->id_company."
        ");
        return response()->json($list);
    }

    public function autocomplete(Request $request){
        $search = $request->cari;
        $id_company = $request->id_company;
        $visitors = DB::select("SELECT
                id,
                name,
                ktp,
                email
            FROM visitor
            WHERE id_company = ".$id_company." && name like '%".$search."%' LIMIT 5
        ");
        // $visitor_list = [];
        // foreach($visitors as $visitor) {
        //     array_push($visitor_list,$_company->name);
        // }

        $response = [];
        foreach($visitors as $visitor){
            $response[] = array(
                "id" => $visitor->id,
                "name" => $visitor->name,
                "label" => $visitor->name,
                "ktp" =>$visitor->ktp,
                "email" => $visitor->email
            );
        };

        // dd($response);
        return response()->json($response);
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
}
