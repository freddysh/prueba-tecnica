<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('formulario.index');
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
        try {
            $v = \Validator::make($request->all(), [
                'nombre' => 'required',
                'email'    => 'required|email|unique:formularios',
                'rut' => 'required',
                'fecha_nacimiento' => 'required',
                'region' => 'required',
                'provincia' => 'required',
                'comuna' => 'required',
            ]);
            if ($v->fails())
            {
                return response()->json(['status'=>'0','mensaje'=>$v->errors()]);
            }
            $formualrio=new Formulario();
            $formualrio->nombre=$request->nombre;
            $formualrio->email=$request->email;
            $formualrio->rut=$request->rut;
            $formualrio->fecha_nacimiento=$request->fecha_nacimiento;
            $formualrio->region=$request->region;
            $formualrio->provincia=$request->provincia;
            $formualrio->comuna=$request->comuna;
            if($formualrio->save()){
                return response()->json(['status'=>'1','mensaje'=>'Formulario enviado!']);
            }
            else{
                return response()->json(['status'=>'0','mensaje'=>'Error al guardar el formulario, por favor intentalo otra vez']);
            }
        }
        catch (\Throwable $th) {
            return response()->json(['status'=>'0','mensaje'=>$th]);
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
