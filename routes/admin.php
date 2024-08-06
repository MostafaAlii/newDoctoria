<?php

use App\Http\Controllers\Admin\{AuthController, HomeController,};
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/admin',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {


    Route::get('login', [AuthController::class, 'loginView'])->name('admin.login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('admin.postLogin');

});



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/admin',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ,'admin']
    ], function() {


    Route::group([ 'middleware' => 'admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ], function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');
        Route::get('requests_calenders', [HomeController::class, 'requests_calenders'])->name('admin.requests_calenders');

        Route::get('calender', [HomeController::class, 'calender'])->name('admin.calender');

        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

        ### admins

        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::get('activateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');



        ### Languages
        Route::resource('languages', \App\Http\Controllers\Admin\LanguageController::class);
        Route::get('activateLanguage', [App\Http\Controllers\Admin\LanguageController::class, 'activate'])->name('admin.active.language');



        ### Nationalities
        Route::resource('nationalities', \App\Http\Controllers\Admin\NationalityController::class);

        ### cities
        Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

        ### governorates
        Route::resource('governorates', \App\Http\Controllers\Admin\GovernorateController::class);


        ### categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        ### types
        Route::resource('types', \App\Http\Controllers\Admin\TypeController::class);

        ### provider types
        Route::resource('provider_types', \App\Http\Controllers\Admin\ProviderTypeController::class);

        ### provider
        Route::resource('providers', \App\Http\Controllers\Admin\ProviderController::class);

        ### families
        Route::resource('families', \App\Http\Controllers\Admin\FamilyController::class);



        ### areas
        Route::resource('areas', \App\Http\Controllers\Admin\AreaController::class);




        ### setting
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);



        ### Experiences
        Route::resource('experiences', \App\Http\Controllers\Admin\ExperienceController::class);





        ### Employees
        Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);

        ### Employees
        Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);


        ### Doctors
        Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
        Route::get('doctor/{id}/approved', [\App\Http\Controllers\Admin\DoctorController::class, 'approved'])->name('admin.update.doctor');
        Route::post('doctor/{id}/approved', [\App\Http\Controllers\Admin\DoctorController::class, 'approvedUpdate'])->name('update.doctor.approved');
        Route::get('get_categories_by_main_service', [\App\Http\Controllers\Admin\DoctorController::class, 'get_categories_by_main_service'])->name('admin.get_categories_by_main_service');

        Route::get('doctor_times/{id}', [\App\Http\Controllers\Admin\DoctorController::class, 'doctor_times'])->name('admin.doctor_times');
        Route::post('update_doctor_times/{id}', [\App\Http\Controllers\Admin\DoctorController::class, 'update_doctor_times'])->name('admin.update_doctor_times');
        Route::get('get_city_by_governorate', [\App\Http\Controllers\Admin\DoctorController::class, 'get_city_by_governorate'])->name('admin.get_city_by_governorate');
        Route::get('get_sub_specialization', [\App\Http\Controllers\Admin\DoctorController::class, 'get_sub_specialization'])->name('admin.get_sub_specialization');
        Route::get('activateDoctor', [App\Http\Controllers\Admin\DoctorController::class, 'activate'])->name('admin.active.doctor');

        Route::get('doctors_branches/{id}', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'index'])->name('admin.doctors_branches.index');
        Route::get('doctors_branches/{id}/create', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'create'])->name('doctors_branches.create');
        Route::post('doctors_branches/{id}/store', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'store'])->name('doctors_branches.store');
        Route::get('doctors_branches/{id}/edit', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'edit'])->name('doctors_branches.edit');
        Route::put('doctors_branches/{id}/update', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'update'])->name('doctors_branches.update');

        Route::delete('doctors_branches/delete/{id}', [\App\Http\Controllers\Admin\DoctorBranchController::class , 'destroy'])->name('doctors_branches.destroy');

        Route::get('doctor_branches_times/{id}', [\App\Http\Controllers\Admin\DoctorBranchController::class, 'doctor_times'])->name('admin.doctor_branches_times');
        Route::post('update_doctor_branches_times/{id}', [\App\Http\Controllers\Admin\DoctorBranchController::class, 'update_doctor_times'])->name('admin.update_doctor_branches_times');


        ### Patients
        Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class);
        Route::get('getCityByNationality', [App\Http\Controllers\Admin\PatientController::class, 'getCityByNationality'])->name('admin.getCityByNationality');


        ### Days
        Route::resource('days', \App\Http\Controllers\Admin\DayController::class);

        ### Laboratories
        Route::resource('laboratories', \App\Http\Controllers\Admin\LaboratoryController::class);



        Route::get('laboratory/export', [\App\Http\Controllers\Admin\LaboratoryController::class, 'export'])->name('laboratories.export');
        Route::get('laboratory/import', [\App\Http\Controllers\Admin\LaboratoryController::class, 'import'])->name('laboratories.import');
        Route::post('laboratory/update_import', [\App\Http\Controllers\Admin\LaboratoryController::class, 'update_import'])->name('laboratories.update_import');


        Route::resource('laboratory_branches', \App\Http\Controllers\Admin\LaboratoryBranchController::class);

        ### Laboratories
        Route::resource('analysis', \App\Http\Controllers\Admin\AnalysisController::class);

        Route::get('analysis_export/export', [\App\Http\Controllers\Admin\AnalysisController::class, 'export'])->name('analysis.export');
        Route::get('analysis_import/import', [\App\Http\Controllers\Admin\AnalysisController::class, 'import'])->name('analysis.import');
        Route::post('analysis_import/update_import', [\App\Http\Controllers\Admin\AnalysisController::class, 'update_import'])->name('analysis.update_import');


        ### Sliders
        Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);


        ###  Specializations
        Route::resource('specializations', \App\Http\Controllers\Admin\SpecializationController::class);

        ###  Sub Specializations
        Route::resource('sub_specializations', \App\Http\Controllers\Admin\SubSpecializationController::class);



        ###  Main Services
        Route::resource('main_services', \App\Http\Controllers\Admin\MainServiceController::class);


        ###  Medical Bags
        Route::resource('medical_bags', \App\Http\Controllers\Admin\MedicalBagController::class);


        ###  Medical File Patients
        Route::resource('medical_file_patients', \App\Http\Controllers\Admin\MedicalFilePatientController::class);

        ###  Radiology Center
        Route::resource('radiology_centers', \App\Http\Controllers\Admin\RadiologyCenterController::class);

        Route::get('radiology_center/export', [\App\Http\Controllers\Admin\RadiologyCenterController::class, 'export'])->name('radiology_center.export');
        Route::get('radiology_center/import', [\App\Http\Controllers\Admin\RadiologyCenterController::class, 'import'])->name('radiology_center.import');
        Route::post('radiology_center/update_import', [\App\Http\Controllers\Admin\RadiologyCenterController::class, 'update_import'])->name('radiology_center.update_import');


        Route::resource('radiology_center_branches', \App\Http\Controllers\Admin\RadiologyCenterBranchController::class);


        ###  insurance people
        Route::resource('insurance_people', \App\Http\Controllers\Admin\InsurancePeopleController::class);


        ### insurance Company
        Route::resource('insurance_companies', \App\Http\Controllers\Admin\InsuranceCompanyController::class);


        ### patient  Subscribe
        Route::resource('patient_subscribes', \App\Http\Controllers\Admin\PatientSubscribeController::class);



        ###  Medication Types
        Route::resource('medication_ways', \App\Http\Controllers\Admin\MedicationWayController::class);



        ### Medication Units
        Route::resource('medication_units', \App\Http\Controllers\Admin\MedicationUnitController::class);

        Route::get('medication_unit/export', [\App\Http\Controllers\Admin\MedicationUnitController::class, 'export'])->name('medication_unit.export');
        Route::get('medication_unit/import', [\App\Http\Controllers\Admin\MedicationUnitController::class, 'import'])->name('medication_unit.import');
        Route::post('medication_unit/update_import', [\App\Http\Controllers\Admin\MedicationUnitController::class, 'update_import'])->name('medication_unit.update_import');

        ### Solution Types
        Route::resource('solution_types', \App\Http\Controllers\Admin\SolutionTypeController::class);

        ### Diagnosis
        Route::resource('diagnoses', \App\Http\Controllers\Admin\DiagnosisController::class);


        ### Solution Priorities
        Route::resource('solution_priorities', \App\Http\Controllers\Admin\SolutionPriorityController::class);


        ###   Bookings
        Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);
        Route::get('booking_docs/{id}', [App\Http\Controllers\Admin\BookingController::class, 'booking_docs'])->name('admin.booking_docs');



        ###  Request  Bookings
        Route::resource('request_bookings', \App\Http\Controllers\Admin\RequestBookController::class);
        Route::get('request_booking_docs/{id}', [App\Http\Controllers\Admin\RequestBookController::class, 'request_booking_docs'])->name('admin.request_booking_docs');


        ### Notification
        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationController::class);

        ##################################  SC   ############################################

        ### Sc categories
        Route::resource('sc_categories', \App\Http\Controllers\Admin\Sc\CategoryController::class);

        ### Sc Types
        Route::resource('sc_types', \App\Http\Controllers\Admin\Sc\TypeController::class);

        ### Sc Services
        Route::resource('sc_services', \App\Http\Controllers\Admin\Sc\ServiceController::class);

        ### symptom
        Route::resource('sc_symptoms', \App\Http\Controllers\Admin\Sc\SymptomController::class);

        ### addons
        Route::resource('sc_addons', \App\Http\Controllers\Admin\Sc\AddOnController::class);



        ### Select Providers
        Route::resource('select_providers', \App\Http\Controllers\Admin\SelectProviderController::class);


        ### Pharmacy
        Route::resource('pharmacies', \App\Http\Controllers\Admin\PharmacyController::class);

        Route::resource('pharmacy_branches', \App\Http\Controllers\Admin\PharmacyBranchController::class);

        Route::get('pharmacy/export', [\App\Http\Controllers\Admin\PharmacyController::class, 'export'])->name('pharmacy.export');
        Route::get('pharmacy/import', [\App\Http\Controllers\Admin\PharmacyController::class, 'import'])->name('pharmacy.import');
        Route::post('pharmacy/update_import', [\App\Http\Controllers\Admin\PharmacyController::class, 'update_import'])->name('pharmacy.update_import');


        ### Radiology
        Route::resource('radiology', \App\Http\Controllers\Admin\RadiologyController::class);

        Route::get('radiology_export/export', [\App\Http\Controllers\Admin\RadiologyController::class, 'export'])->name('radiology.export');
        Route::get('radiology_import/import', [\App\Http\Controllers\Admin\RadiologyController::class, 'import'])->name('radiology.import');
        Route::post('radiology_import/update_import', [\App\Http\Controllers\Admin\RadiologyController::class, 'update_import'])->name('radiology.update_import');



        ### Gc Packages
        Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
        Route::get('activateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');




        ### Gc Medication Types
        Route::resource('gc_medication_types', \App\Http\Controllers\Admin\Gc\MedicationTypeController::class);



        ### Gc Medication Time
        Route::resource('gc_medication_times', \App\Http\Controllers\Admin\Gc\MedicationTimeController::class);

        ### Gc Blood Sugar Time
        Route::resource('gc_blood_sugar_units', \App\Http\Controllers\Admin\Gc\BloodSugarUnitController::class);





        ### Gc Nationalities
        Route::resource('gc_nationalities', \App\Http\Controllers\Admin\Gc\NationalityController::class);



        ### Gc Blood Sugar Time
        Route::resource('gc_blood_sugar_times', \App\Http\Controllers\Admin\Gc\BloodSugarTimeController::class);



        ### Signs
        Route::resource('signs', \App\Http\Controllers\Admin\SignController::class);


        ### chronicDisease
        Route::resource('chronic_diseases', \App\Http\Controllers\Admin\ChronicDiseaseController::class);


        ### Medical Operation
        Route::resource('medical_operations', \App\Http\Controllers\Admin\MedicalOperationController::class);


        ### Request Booking
        Route::resource('request_bookings', \App\Http\Controllers\Admin\RequestBookController::class);


        ### hospitals
        Route::resource('hospitals', \App\Http\Controllers\Admin\HospitalController::class);

        ### payment method

        //Route::get('payment/method', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'index']);


        ### OTP CRUD
        Route::resource('main_otp', \App\Http\Controllers\Admin\GeneralMainSetting\MainOtpController::class);
        Route::post('main_otp/update-status/{id}', [\App\Http\Controllers\Admin\GeneralMainSetting\MainOtpController::class, 'updateStatus'])->name('otp_update_status');
    });

});
