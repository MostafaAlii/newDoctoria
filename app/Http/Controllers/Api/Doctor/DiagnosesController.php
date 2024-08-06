<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiagnosisResource;
use App\Http\Resources\MedicationUnitResource;
use App\Http\Resources\MedicationWayResource;
use App\Http\Resources\SolutionPriorityResource;
use App\Http\Resources\SolutionTypeResource;
use App\Http\Traits\Api_Trait;
use App\Models\Diagnosis;
use App\Models\MedicationUnit;
use App\Models\MedicationWay;
use App\Models\SolutionPriority;
use App\Models\SolutionType;
use Illuminate\Http\Request;

class DiagnosesController extends Controller
{
    //
    use Api_Trait;

    public function diagnoses(){
        $diagnoses=Diagnosis::get();

        return $this->returnData(DiagnosisResource::collection($diagnoses),[helperTrans('api.Diagnoses data')],200);

    }
    public function medication_units(){
        $medication_units=MedicationUnit::get();
        return $this->returnData(MedicationUnitResource::collection($medication_units),[helperTrans('api.Medication Unit Data')],200);

    }

    public function solution_types(){
        $solution_types=SolutionType::get();
        return $this->returnData(SolutionTypeResource::collection($solution_types),[helperTrans('api.Solution Type Data')],200);

    }

    public function medication_ways(){
        $medication_ways=MedicationWay::get();
        return $this->returnData(MedicationWayResource::collection($medication_ways),[helperTrans('api.Medication Ways Data')],200);

    }

    public function solution_priorities(){
        $solution_priorities=SolutionPriority::get();
        return $this->returnData(SolutionPriorityResource::collection($solution_priorities),[helperTrans('api.Solution Priorities Data')],200);

    }
}
