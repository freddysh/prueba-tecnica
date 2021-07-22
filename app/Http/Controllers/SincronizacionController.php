<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SincronizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $arreglo=null;
    private $misArchivos=null;
    private $sincronizados=0;
    private $eliminados=0;


    public function sincronizacion($ruta)
    {
        try {
            // $ruta='imagenes';
            $this->sincronizar($ruta);
            $this->eliminar_archivos($ruta);
            return response()->json(['status'=>'1','mensaje'=>'Sincronizacion exitosa!','sincronizados'=>$this->sincronizados,'eliminados'=>$this->eliminados]);

        } catch (\Throwable $th) {
                return response()->json(['status'=>'0','mensaje'=>'Error al sincronizar los datos','sincronizados'=>$this->sincronizados,'eliminados'=>$this->eliminados]);

        }

    }
    protected function sincronizar($ruta)
    {

        //comprueba que sea un directorio
        if(is_dir($ruta))
        {
            // Abre un gestor de directorios para la ruta indicada
            $gestor = opendir($ruta);
            // Recorre todos los elementos del directorio
            while (($archivo = readdir($gestor)) !== false)  {
                $ruta_completa = $ruta . "/" . $archivo;
                // Se muestran todos los archivos y carpetas excepto "." y ".."
                if ($archivo != "." && $archivo != "..") {
                    // Si es un directorio se recorre recursivamente
                    if (is_dir($ruta_completa)) {
                         $this->sincronizar($ruta_completa);
                    } else {
                        // agregamos si no existe el bucket s3
                        if(!Storage::disk('s3')->exists($ruta_completa)){
                            $this->arreglo[]=$ruta_completa;
                            Storage::disk('s3')->put($ruta_completa, $archivo, 'public');
                            $this->sincronizados++;
                        }
                        // guardams los archivos para eliminar los que ya no estan en el bucket s3
                        $this->misArchivos[]=$ruta_completa;
                    }
                }
            }
            // Cierra el gestor de directorios
            closedir($gestor);
        }
    }
    protected function eliminar_archivos($ruta){
        // recuperamos el directorio completo
        $files = Storage::disk('s3')->allFiles();
        // recorremos cada archivo para consultar si existe en nuestra carpeta imagenes
        foreach ($files as $key => $file) {
            if(!in_array($file,$this->misArchivos)){
                // si no existe lo borramos de nuestro bucket s3
                Storage::disk('s3')->delete($file);
                $this->eliminados++;
            }
        }
        return 'Archivos eliminados';
    }

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
}
