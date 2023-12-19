<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::all();

        return response()->json($person, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $person = new Person();
        $person->name = $request->name;
        $person->city_id = $request->city_id;
        $person->point = $request->point;
        $person->save();

        return response()->json($person, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person -> delete();

        return response()->json("Product deleted successfully", 204);
    }

    public function topPersons()
    {

        $person =  DB::table(DB::raw('(SELECT c.id AS city_id, c.name AS city_name, p.id AS person_id, p.name AS person_name, p.point, ROW_NUMBER() OVER (PARTITION BY c.id ORDER BY p.point DESC) AS top FROM people p JOIN cities c ON p.city_id = c.id) as TopData'))
        ->select('city_id', 'person_name', 'city_name', 'person_id', 'point')
        ->where('top', 1)
        ->get();

        return response()->json($person, 200);
    }
}
