<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Programs;
use App\Http\Resources\ProgramsCollection;
use App\Http\Resources\Programs as ProgramsResource;
use App\Http\Controllers\Controller;

class ProgramsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $per_page = (int) $request->query('per_page', 15);

        $collection = new ProgramsCollection(programs::paginate($per_page));

        return $collection->additional([
            'status' => 1
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $rules = [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:64',
                'unique:programs,name',
            ],
            'origin' => [
                'required',
                'string',
                'min:3',
                'max:64',
            ],            
        ];

        $messages = [
            'name.required' => 'Please enter the name of the programme.',
            'name.string' => 'The name should be a string.',
            'name.min' => 'The name should be at least 3 characters long.',
            'name.max' => 'The name should not be longer than 64 characters.',
            'name.unique' => 'The programme ":input" already exists.',
            'origin.required' => 'Please enter the origin of the programme.',
            'origin.string' => 'The origin should be a string.',
            'origin.min' => 'The origin should be at least 3 characters long.',
            'origin.max' => 'The origin should not be longer than 64 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ], 422);

        }

        $programme = Programs::create([
            'name' =>$request->input('name'),
            'origin' =>$request->input('origin')
        ]);
        
        return response()->json($programme, 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $program_id)
    {   
         
        $program = Programs::find($program_id);

        if (is_null($program)) {

            return response()->json([
                'status' => 0,
                'message' => 'Programme not found'
            ], 404);

        }

        return response()->json([
            'status' => 1,
            'data' => $program->toArray()
        ], 200);

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
