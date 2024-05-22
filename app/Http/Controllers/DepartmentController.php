<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('procedure')->get();
        return response()->json([
            'error' => false,
            'departments' => $departments
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
        $request->validate([
            'name' => 'required|string|max:100',
            'abbreviation' => 'required|string|max:10',
        ]);
        try {
            $department = Department::create($request->all());
            return response()->json([
                'message' => 'Creado correctamente',
                'error' => false,
                'department' => $department
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear' . $th->getMessage(),
                'error' => true,
                'department' => null
            ]);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required|string|max:100',
            'abbreviation' =>'required|string|max:10',
        ]);

        try {
            $department = Department::find($id);

            if (!$request) {
                return response()->json([
                    'message' => 'El departamento no existe',
                    'error' => true,
                    'department' => null
                ], 404);
            }

            $department->update($request->all());

            return response()->json([
                'message' => "Departamento actualizado correctamente",
                'error' => false,
                'department' => $department
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al actualizar el departamento: '. $th->getMessage(),
                'error' => true,
                'department' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $department = Department::find($id);
            if (!$department) {
                return response()->json([
                   'message' => 'El departamento no existe',
                    'error' => true,
                    'department' => null
                ], 404);
            }

            $department->delete();

            return response()->json([
               'message' => 'Departamento eliminado correctamente',
                'error' => false,
                'department' => $department
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
               'message' => 'Error al eliminar el departamento: '. $th->getMessage(),
                'error' => true,
                'department' => null
            ], 500);
        }
    }
}
