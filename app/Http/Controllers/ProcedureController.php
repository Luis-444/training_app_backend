<?php

namespace App\Http\Controllers;

use App\Models\{Procedure};
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procedures = Procedure::all();
        return response()->json([
            'error' => false,
            'procedures' => $procedures
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
            'acm_number' => 'required|string|max:10|unique:procedures,acm_number',
            'name' => 'required|string|max:100'
        ]);
        try {
            $procedure = Procedure::create($request->all());
            return response()->json([
                'message' => 'Procedimiento creado correctamente',
                'error' => false,
                'procedure' => $procedure
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear el procedimiento' . $th->getMessage(),
                'error' => true,
                'procedure' => null
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
            'acm_number' => 'required|string|max:10|unique:procedures,acm_number,'.$id,
            'name' => 'required|string|max:100'
        ]);

        try {
            $procedure = Procedure::find($id);

            if (!$procedure) {
                // Si el procedimiento no existe, devuelve un error
                return response()->json([
                    'message' => 'El procedimiento no existe',
                    'error' => true,
                    'procedure' => null
                ], 404);
            }

            // Actualiza los campos del procedimiento con los valores del request
            $procedure->update($request->all());

            return response()->json([
                'message' => 'Procedimiento actualizado correctamente',
                'error' => false,
                'procedure' => $procedure
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al actualizar el procedimiento: ' . $th->getMessage(),
                'error' => true,
                'procedure' => null
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
            $procedure = Procedure::find($id);

            if (!$procedure) {
                // Si el procedimiento no existe, devuelve un error
                return response()->json([
                    'message' => 'El procedimiento no existe',
                    'error' => true,
                    'procedure' => null
                ], 404);
            }

            // Elimina el procedimiento
            $procedure->delete();

            return response()->json([
                'message' => 'Procedimiento eliminado correctamente',
                'error' => false,
                'procedure' => $procedure
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al eliminar el procedimiento: ' . $th->getMessage(),
                'error' => true,
                'procedure' => null
            ], 500);
        }
    }

    public function addProcedure(Request $request){
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'procedure_id' => 'required|exists:procedures,id',
        ]);
        try {
            $employeeProcedure = EmployeeProcedure::create($request->all());
            return response()->json([
                'message' => 'Procedimiento creado correctamente',
                'error' => false,
                'employeeProcedure' => $employeeProcedure
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear el procedimiento' . $th->getMessage(),
                'error' => true,
                'procedure' => null
            ]);
        }
    }
}
