<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;


use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Empleoyes;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DataTables;


class ReportController extends Controller
{

 
    public function index()
    {

        return view ('admin.report.asistencia');
    }


  

 
    public function getEmpleoyes(Request $request){

        $date_start = \Carbon\Carbon::parse($request->date_start)->startOfDay();
        $date_end = \Carbon\Carbon::parse($request->date_end)->endOfDay();
        $city=$request->city;

        $asistencia = Attendance::with('empleado', 'empleado.area', 'empleado.charge')
        ->whereHas('empleado', function ($query) use ($city) {
            $query->where('city', $city);
        })
        ->whereBetween('created_at', [$date_start, $date_end])
        ->get();

       
            return Datatables::of($asistencia)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
          
    }

    
    public function asistencia()
    {

        return view ('admin.report.reportasistencia');
    }

    public function getEmpleoyesAsistencia(Request $request){

        

        $dateStart = $request->date_start; // Fecha de inicio
        $dateEnd = $request->date_end;   // Fecha de fin
        $startDate = \Carbon\Carbon::parse($dateStart);
        $endDate = \Carbon\Carbon::parse($dateEnd);
        $city=$request->city;
        
       
        $inasistencia=[];
        $dias=[];
        while ($startDate <= $endDate) {
            // Para cada día en el rango, consultar los empleados que no tienen asistencia en ese día
            $empleados = Empleoyes::with('area', 'charge')->where('city', $city)->where('state',1)->get();
            foreach($empleados as $key=>$item){
                $asistencia = Attendance::where('empleoye_id',$item->id)->whereDate('created_at',$startDate->toDateString())->get();    
                          
                if(count($asistencia)==0){
                    $empleados[$key]['asistio']=0;
                }else{
                    $empleados[$key]['asistio']=1;
                }
                $empleados[$key]['fecha']=$startDate->toDateString();
                $empleados[$key]['yyy']=$key;
                array_push($inasistencia,$item);
            }
            
            array_push($dias,$startDate->toDateString());
            // Avanzar al siguiente día
            $startDate->addDay();
        }

       //dd($dias);

            return Datatables::of($inasistencia)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
          
    }


}
