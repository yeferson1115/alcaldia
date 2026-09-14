<?php

namespace App\Imports;

use App\Models\Empleoyes;
use App\Models\Institution;
use App\Models\InstitutionsCampus;
use App\Models\Groups;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class EmpleoyesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $key=>$row)
        {
            if($row[2]!=null && $row[2]!=''){
            
            if($key>0){
                $empleoye=Empleoyes::where('document',trim($row[3]))->first();               
                if($empleoye!=null){                    
                    $empleoye->name=$row[0]; 
                    $empleoye->last_name=$row[1];
                    $empleoye->type_document=trim($row[2]);
                    $empleoye->document=trim($row[3]);
                    $empleoye->sex=trim($row[4]);                    
                    $empleoye->phone=(string)trim($row[5]);
                    $empleoye->rh=trim($row[6]);                    
                    $empleoye->area_id=$row[7];
                    $empleoye->role_id=$row[8];
                    $empleoye->city = $row[9];
                    $empleoye->state=1;
                    $empleoye->save();

                    


                }else{
                   Empleoyes::create([
                        'name'=> $row[0], 
                        'last_name' => $row[1],
                        'type_document' => trim($row[2]),
                        'document' => trim($row[3]),
                        'sex' => trim($row[4]),
                        'phone' => $row[5],
                        'rh' => (string)trim($row[6]),
                        'area_id' => $row[7],
                        'role_id' => $row[8],  
                        'city' => $row[9], 
                        'state'=>1
                    ]);


                }  
                
            }
        }
            
        }

    }
}
