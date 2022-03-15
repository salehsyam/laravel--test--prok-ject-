<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\import;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imports = import::all();
        return response()->view('import.index', ['imports' => $imports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services =Service::all();
        $people =Employee::all();
        return response()->view('import.create',[
            'services' =>$services,
            'people' =>$people
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
        $validator = Validator($request->all(), [

            'description'=>'nullable',
            'date'=>'date',
            'employee_id' => 'required|int|exists:employees,id',
            'service_id' => 'required|int|exists:services,id',
        ])->validate();

        $imports =new import();
        $imports->employee_id = $request->input('employee_id');
        $imports->service_id = $request->input('service_id');
        $imports->date = $request->input('date');
        $imports->description = $request->input('description');
        $isSaved = $imports->save();
        return response()->json(
            ['message' => $isSaved ? __('created successfully') : __('Create failed!')],
            $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST,
        );



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\import  $import
     * @return \Illuminate\Http\Response
     */
    public function show(import $import)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\import  $import
     * @return \Illuminate\Http\Response
     */
    public function edit(import $import)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\import  $import
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, import $import)
    {
        $validator = Validator($request->all(), [

            'description'=>'nullable',
            'date'=>'date',
            'employee_id' => 'required|int|exists:employees,id',
            'service_id' => 'required|int|exists:services,id',
        ])->validate();
        $import->employee_id = $request->input('employee_id');
        $import->service_id = $request->input('service_id');
        $import->date = $request->input('date');
        $import->description = $request->input('description');
        $isSaved = $import->save();
        return response()->json(
            ['message' => $isSaved ? __('Updated successfully') : __('Update failed!')],

            $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\import  $import
     * @return \Illuminate\Http\Response
     */
    public function destroy(import $import)
    {
        $isDeleted = $import->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Deleted successfully' : 'Delete failed!'],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
