<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProcedure;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('department', 'procedures')->get();
        return response()->json([
            'error' => false,
            'employees' => $employees
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
            'initials' => 'required|string',
            'employee_number' => 'required|integer',
            'department_id' => 'required|integer',
            'trainner_email' => 'required|email',
        ]);
        try {
            $employee = Employee::create($request->all());
            return response()->json([
                'message' => 'Creado correctamente',
                'error' => false,
                'employee' => $employee
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear' . $th->getMessage(),
                'error' => true,
                'employee' => null
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
            'name' => 'required|string|max:100',
            'initials' => 'required|string',
            'trainner_email' => 'required|email',
            'employee_number' => 'required|integer',
            'department_id' => 'required|integer',
        ]);

        try {
            $employee = Employee::find($id);

            if (!$employee) {
                // Si el empleado no existe, devuelve un error
                return response()->json([
                    'message' => 'El empleado no existe',
                    'error' => true,
                    'employee' => null
                ], 404);
            }

            // Actualiza los campos del empleado con los valores del request
            $employee->update($request->all());

            return response()->json([
                'message' => 'Empleado actualizado correctamente',
                'error' => false,
                'employee' => $employee
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al actualizar el empleado: ' . $th->getMessage(),
                'error' => true,
                'employee' => null
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
            $employee = Employee::find($id);

            if (!$employee) {
                // Si el empleado no existe, devuelve un error
                return response()->json([
                    'message' => 'El empleado no existe',
                    'error' => true,
                    'employee' => null
                ], 404);
            }

            // Elimina el empleado
            $employee->delete();

            return response()->json([
                'message' => 'Empleado eliminado correctamente',
                'error' => false,
                'employee' => $employee
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al eliminar el empleado: ' . $th->getMessage(),
                'error' => true,
                'employee' => null
            ], 500);
        }
    }
}
