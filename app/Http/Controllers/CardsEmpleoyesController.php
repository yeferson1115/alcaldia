<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleoyes;
use App\Models\CardsEmpleoyes;
use Endroid\QrCode\Builder\Builder;

use Illuminate\Support\Facades\Http;

use PDF;

 set_time_limit(300);

 use QrCode;

 use Intervention\Image\Facades\Image;
 use Intervention\Image\ImageManager;

 use ZipArchive;

class CardsEmpleoyesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        /*$empleoyes = Empleoyes::with('area', 'charge')
        ->where('state', 1)
        ->whereNotNull('phone')
        ->orderBy('last_name', 'asc')
        ->get();

         $fondo='http://localhost:81/plantillas/CARNET.png';
        foreach($empleoyes as $item){
            //$item->photo='https://saasonline.com.co/images/photos/'.$item->photo;
            $item->photo='http://localhost:81/images/empleoyes/'.$item->photo;
            $item->qr=base64_encode(QrCode::format('svg')->size(55)->generate($item->document));
        }
        $name_pdf = time().'_carnets.pdf';
       
        return view ('admin.cardsid.templates.carnets',compact('empleoyes','fondo'));

       $pdf = PDF::loadView('admin.cardsid.templates.'.auth()->user()->institution->id,compact('students','fondo'))
        ->setPaper('A4', 'portrait')->save(public_path('carnets/'.$name_pdf));*/
        
        $cards = CardsEmpleoyes::with('user','empleado')->get();
        return view ('admin.cardsid.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $empleoyes = Empleoyes::with('area', 'charge')
        ->where('state', 1)
        ->whereNotNull('photo')
        ->orderBy('last_name', 'asc')
        ->get();
    
        
        return view ('admin.cardsid.empleoyes', compact('empleoyes'));
    }


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            // Validar que al menos un checkbox esté seleccionado
            if (empty($request->empleoye_id)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Debe seleccionar al menos un empleado.',
                ], 400); // Código de estado 400 para bad request
            }
            $empleoyes = Empleoyes::with('area', 'charge')
            ->where('state', 1)
            ->whereNotNull('photo')
            ->whereIn('id', $request->empleoye_id)
            ->orderBy('last_name', 'asc')
            ->get();

            // Verificar si se encontraron empleados
            if ($empleoyes->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontraron empleados con los datos proporcionados.',
                ], 404); // Código de estado 404 si no se encuentran registros
            }

           $plantilla = asset('plantillas/CARNET.png');
           $carnets=[];
            
            foreach($empleoyes as $item){
                $manager = new ImageManager(['driver' => 'gd']);

                $img = $manager->make($plantilla)->resize(684, 1041); 

                /**preguntamos si es CONTRATISTA */
                if($item->charge->name=='CONTRATISTA'){
                    $imagenUsuario=asset('images/escudo.png'); 
                }else{
                    $imagenUsuario=asset('images/empleoyes/'.$item->photo); 
                }
                
                $imgUsuario = Image::make($imagenUsuario)->fit(353, 473);
                
                $img->insert($imgUsuario, 'top-left', 165, 196); // Ajusta posición
                // Insertar texto (nombre, documento, etc.)
                $nombreCompleto = $item->name . ' ' . $item->last_name;

                $nombre = $item->name . ' ' . $item->last_name;

                $this->escribirNombreCentrado($item->id,$img, $item->name,$item->last_name,$item->type_document,$item->document, $item->charge->name,$item->rh);
                
                $result = Builder::create()
                ->data($item->id)
                ->size(200)
                ->margin(0)
                ->build();

                // Guardar temporalmente
                $qrPath = storage_path('app/temp_qr.png');
                file_put_contents($qrPath, $result->getString());

                // Cargarlo con Intervention y pegarlo
                $qrImage = Image::make($qrPath);                
                $img->insert($qrImage, 'bottom-left', 40, 100);
                
                // Opcional: guardar en disco
                $rutaCarnet = 'carnets/carnet_' . $item->id . '.png';
                $img->save(public_path('carnets/carnet_' . $item->id . '.png'));

                $card=CardsEmpleoyes::where('empleoye_id',$item->id)->first();
                if($card){
                    $card->carnet= $rutaCarnet;
                    $card->user_id = auth()->user()->id;
                    $card->save();
                }else{
                    $cards = new CardsEmpleoyes();
                    $cards->empleoye_id = $item->id;  
                    $cards->carnet = $rutaCarnet;
                    $cards->user_id = auth()->user()->id;
                    $cards->save();
                }

                array_push($carnets,public_path($rutaCarnet)); 
            }

            if(count($carnets)>0){
                $nombreZip = 'carnets.zip';
                $rutaZip = public_path($nombreZip); // Guarda directamente en /public
            
                $zip = new ZipArchive;
                if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($carnets as $imagen) {
                        if (file_exists($imagen)) {
                            $zip->addFile($imagen, basename($imagen)); // nombre dentro del zip
                        }
                    }
                    $zip->close();
                } else {
                    return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
                }
            }
           
            return response()->json([
                'status' => 'success',
                'message' => 'Carnets creados correctamente.',
                ///'pdf_url' => url('carnets/' . $name_pdf),
            ], 200); // Código de estado 200 para éxito

        } catch (\Exception $e) {
            // Manejar cualquier error inesperado
            return response()->json([
                'status' => 'error',
                'message' => 'Error al generar los carnets: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores internos del servidor
        }
    }

function escribirNombreCentrado($id,$img, $nombre, $apellido, $tipoDocumento, $documento, $cargo, $rh, $startY = 774, $fontSize = 25, $lineHeight = 32, $fontPath = null)
{
    if($cargo=='CONTRATISTA'){
        $nombre='CONTRATISTA #'.$id;
        $apellido='';
        $tipoDocumento='';
        $documento='';
        $cargo='';
        $rh='';
        $fontSize = 35;
        $cargotemp='CONTRATISTA';
    }else{
        $cargotemp=$cargo;
    }
    $fontPath = $fontPath ?: public_path('fonts/Roboto-Regular.ttf');
    
    $fontSizeSmall = $fontSize - 5;

    $xLeft = 260;
    $maxWidth = 400;

    // 1. Nombre
    $nombre = strtoupper($nombre);
    $img->text($nombre, $xLeft, $startY, function ($font) use ($fontPath, $fontSize) {
        $font->file($fontPath);
        $font->size(32);
        $font->color('#000000');
    });
    $startY += $lineHeight+5;

    // 2. Apellido
    $apellido = strtoupper($apellido);
    $img->text($apellido, $xLeft, $startY, function ($font) use ($fontPath, $fontSize) {
        $font->file($fontPath);
        $font->size(32);
        $font->color('#000000');
    });
    $startY += $lineHeight;

    // 3. Documento
    $textoDocumento = strtoupper(trim($tipoDocumento . ' ' . $documento));
    $img->text($textoDocumento, $xLeft, $startY, function ($font) use ($fontPath, $fontSizeSmall) {
        $font->file($fontPath);
        $font->size($fontSizeSmall);
        $font->color('#000000');
    });
    $startY += $lineHeight;

    // 4. Cargo
    $cargo = strtoupper(trim($cargo));
    $lineas = [];
    $palabras = explode(' ', $cargo);
    $lineaActual = '';

    foreach ($palabras as $palabra) {
        $tempLinea = trim($lineaActual . ' ' . $palabra);
        $box = imagettfbbox($fontSizeSmall, 0, $fontPath, $tempLinea);
        $anchoTemp = abs($box[2] - $box[0]);

        if ($anchoTemp <= $maxWidth) {
            $lineaActual = $tempLinea;
        } else {
            $lineas[] = $lineaActual;
            $lineaActual = $palabra;
        }
    }

    if (!empty($lineaActual)) {
        $lineas[] = $lineaActual;
    }

    foreach ($lineas as $linea) {
        $img->text($linea, $xLeft, $startY, function ($font) use ($fontPath, $fontSizeSmall) {
            $font->file($fontPath);
            $font->size($fontSizeSmall);
            $font->color('#000000');
        });
        $startY += $lineHeight;
    }

    // 5. RH
    if($cargotemp!='CONTRATISTA'){
        $rhTexto = 'RH: ' . strtoupper(trim($rh));
        $img->text($rhTexto, $xLeft, $startY, function ($font) use ($fontPath, $fontSizeSmall) {
            $font->file($fontPath);
            $font->size($fontSizeSmall);
            $font->color('#000000');
        });
    }

    return $img;
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
        
        CardsEmpleoyes::find($id)->delete();
        return json_encode(['success' => true]);
    }
}
