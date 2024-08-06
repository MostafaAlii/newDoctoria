<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalysisResource;
use App\Http\Resources\ChronicDiseaseOperationResource;
use App\Http\Resources\ChronicDiseaseResource;
use App\Http\Resources\MedicalFilePatientResource;
use App\Http\Resources\MedicalOperationResource;
use App\Http\Resources\PatientMedicalOperationResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\RadiologyResource;
use App\Http\Resources\SignResource;
use App\Http\Traits\Api_Trait;
use App\Models\Analysis;
use App\Models\ChronicDisease;
use App\Models\MedicalFilePatient;
use App\Models\MedicalOperation;
use App\Models\Patient;
use App\Models\PatientChronicDisease;
use App\Models\PatientChronicDiseaseOperation;
use App\Models\PatientMedicalOperation;
use App\Models\PatientSign;
use App\Models\Radiology;
use App\Models\ReplyingBookingAnalysis;
use App\Models\ReplyingBookingRadiology;
use App\Models\Sign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalFileController extends Controller
{
    use Api_Trait;
    //
    public function index(Request $request){


        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required|exists:categories,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        $patient=auth('patient')->user();

        $medical_file=MedicalFilePatient::with(['category'])->where('category_id',$request->category_id)->where('patient_id',$patient->id)->first();
        if (!$medical_file){
            $new=MedicalFilePatient::create([
                'patient_id'=>$patient->id,
                'category_id'=>$request->category_id,
                'value'=>null,
            ]);
            $medical_file=MedicalFilePatient::with(['category'])->find($new->id);
        }

        return $this->returnData(MedicalFilePatientResource::make($medical_file),[helperTrans('api.Medical file data')],200);

    }
    public function update (Request $request){

        $validator = Validator::make($request->all(),
            [
                'medical_file_patient_id' => 'required|exists:medical_file_patients,id',
                'value' => 'required',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=auth('patient')->user();

        $medical_file=MedicalFilePatient::where('patient_id',$patient->id)->find($request->medical_file_patient_id);

        if (!$medical_file){
            return  $this->returnError([helperTrans('api.this File Not Belong To this Patient')]);
        }

        $medical_file->update([
            'value'=>$request->value,
        ]);

        return $this->returnSuccessMessage([helperTrans('api.the medical file updated successfully')]);


    }

    public function my_personal_data(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);


        return $this->returnData(PatientResource::make($patient),[helperTrans('api.Patient data')],200);


    }

    public function update_my_personal_data(Request $request){
        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'age'=>'nullable|numeric',
                'marital_status'=>'nullable|in:single,married',
                'occupation'=>'nullable',
                'residence'=>'nullable',
                'athlete'=>'nullable',
                'is_alcoholic'=>'nullable|in:0,1',
                'is_smoking'=>'nullable|in:0,1',
                'n_children'=>'nullable|numeric'

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        $validatedData = $validator->validated();

        unset($validatedData['patient_id']);


        $nullableFields = ['age', 'marital_status', 'occupation', 'residence', 'athlete', 'is_alcoholic', 'is_smoking', 'n_children'];
        foreach ($nullableFields as $field) {
            if ($request[$field]==null) {
              unset(  $validatedData[$field] );
            }
        }


        $patient->update($validatedData);

        $patient->update($validatedData);


        $patient->update($validatedData);


        return $this->returnSuccessMessage([helperTrans('api.updated successfully')]);


    }

    public function signs(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        $signs=Sign::where('patient_id',null)->orWhere('patient_id',$request->patient_id)->get();

        return $this->returnData(SignResource::collection($signs),[helperTrans('api.Signs data')],200);

    }


    public function update_signs(Request $request){


        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'sign_id'=>'nullable|array',
                'sign_id.*'=>'nullable',
                'text'=>'nullable',
                'text.*'=>'nullable|string',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        if ($request->sign_id){
            PatientSign::where('patient_id',$patient->id)->whereNotIn('sign_id',$request->sign_id)->delete();
             foreach ($request->sign_id as $sign_id){
                 $sign=Sign::find($sign_id);
                 if ($sign) {
                     PatientSign::updateOrCreate([
                         'patient_id' => $patient->id,
                         'sign_id' => $sign_id,
                     ]);
                 }
             }
        }
        else{
            PatientSign::where('patient_id',$patient->id)->delete();
        }


        if ($request->text){
            foreach ($request->text as $text){

                $result = [
                    "ar" => $text,
                    "en" => $text
                ];
                $sign=Sign::create([
                    'name'=>$result,
                    'patient_id'=>$patient->id,
                ]);
                PatientSign::create([
                    'patient_id'=>$patient->id,
                    'sign_id'=>$sign->id,
                ]);
            }
        }

        return $this->returnSuccessMessage([helperTrans('api.updated successfully')]);

    }

    public function medical_operations(){
        $medicalOperations=MedicalOperation::get();

        return $this->returnData(MedicalOperationResource::collection($medicalOperations),[helperTrans('api.Medical Operation data')],200);

    }

    public function chronic_diseases(){
        $chronic_diseases=ChronicDisease::get();
        return $this->returnData(ChronicDiseaseResource::collection($chronic_diseases),[helperTrans('api.Chronic Diseases data')],200);

    }

    public function patient_chronic_diseases_operations(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $chronicDiseaseOperations=PatientChronicDiseaseOperation::with(['medicalOperation','chronicDisease'])->where('patient_id',$request->patient_id)->get();

        return $this->returnData(ChronicDiseaseOperationResource::collection($chronicDiseaseOperations),[helperTrans('api.Chronic Diseases Operation data')],200);


    }

    public function add_patient_chronic_diseases_operations(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'chronic_disease_id'=>'required|exists:chronic_diseases,id',
                'medical_operation_id'=>'required|exists:medical_operations,id',
                'date_of_operation'=>'required|date',
                'note'=>'required',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }
        $data = $validator->validated();
        $row=PatientChronicDiseaseOperation::create($data);
        $chronicDiseaseOperation=PatientChronicDiseaseOperation::with(['medicalOperation','chronicDisease'])->find($row->id);

        return $this->returnData(ChronicDiseaseOperationResource::make($chronicDiseaseOperation),[helperTrans('api.Chronic Diseases Operation data')],200);
    }

    public function patient_analysis(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $analysis_ides=ReplyingBookingAnalysis::where('patient_id',$request->patient_id)->pluck('analysis_id')->toArray();


            $analysis=Analysis::with(['laboratory'])->whereIn('id',$analysis_ides)->get();


        return $this->returnData(AnalysisResource::collection($analysis),[helperTrans('api.Analysis Data')],200);

    }

    public function patient_radiology(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $radiology_ides=ReplyingBookingRadiology::where('patient_id',$request->patient_id)->pluck('radiology_id')->toArray();


        $radiology=Radiology::with(['radiologyCenter'])->whereIn('id',$radiology_ides)->get();


        return $this->returnData(RadiologyResource::collection($radiology),[helperTrans('api.Radiology Data')],200);


    }

    public function patient_chronic_diseases(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        return $this->returnData(ChronicDiseaseResource::collection($patient->chronicDisease),[helperTrans('api.Chronic Disease Data')]);

    }

    public function add_chronic_diseases(Request $request){

        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'chronic_disease_id'=>'required|array',
                'chronic_disease_id.*'=>'required|exists:chronic_diseases,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        if ($request->chronic_disease_id){
            PatientChronicDisease::where('patient_id', $request->patient_id)->delete();
            foreach ($request->chronic_disease_id as $chronic_disease_id)
                PatientChronicDisease::create([
                    'patient_id'=>$patient->id,
                    'chronic_disease_id'=>$chronic_disease_id,
                ]);
        }

        return  $this->returnSuccessMessage([helperTrans('api.added successfully')]);
    }


    public function patient_medical_operations(Request $request){
        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        $patient_medical_operations=PatientMedicalOperation::with(['medicalOperation'])->where('patient_id',$patient->id)->get();


        return $this->returnData(PatientMedicalOperationResource::collection($patient_medical_operations),[helperTrans('api.Patient Medical Operation Data')]);


    }

    public function add_medical_operations(Request $request){
        $validator = Validator::make($request->all(),
            [
                'patient_id' => 'required|exists:patients,id',
                'medical_operation_id'=>'required|exists:medical_operations,id',
                'date_of_operation'=>'required|date',
                'note'=>'nullable',

            ], []);
        if ($validator->fails()) {
            return $this->returnErrorValidation(collect($validator->errors())->flatten(1),403);
        }

        $patient=Patient::find($request->patient_id);

        $row=  PatientMedicalOperation::create([
           'patient_id'=>$patient->id,
            'medical_operation_id'=>$request->medical_operation_id,
            'date_of_operation'=>$request->date_of_operation,
            'note'=>$request->note,
        ]);
        $row_id=$row->id;
        $patient_medical_operation=PatientMedicalOperation::with(['medicalOperation'])->find($row_id);

        return $this->returnData(PatientMedicalOperationResource::make($patient_medical_operation),[helperTrans('api.Patient Medical Operation Data')]);


    }



}
