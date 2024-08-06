<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('login-voucher', [\App\Http\Controllers\Api\Auth\AuthController::class, 'loginWithVoucher']);
    Route::post('signup', [\App\Http\Controllers\Api\Auth\AuthController::class, 'signup']);
    Route::post('logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
    Route::post('delete_app_id', [\App\Http\Controllers\Api\Auth\AuthController::class, 'delete_app_id']);

    Route::post('update_firebase_token', [\App\Http\Controllers\Api\Firebase\FirebaseController::class, 'update_firebase_token']);

    Route::post('fetch-agora-token', [\App\Http\Controllers\Api\Auth\AuthController::class, 'fetchAgoraToken']);


    Route::get('my_profile', [\App\Http\Controllers\Api\Auth\AuthController::class, 'my_profile']);
    Route::post('update_my_profile', [\App\Http\Controllers\Api\Auth\AuthController::class, 'update_my_profile']);

    Route::post('check_phone_number', [\App\Http\Controllers\Api\Auth\AuthController::class, 'check_phone_number']);
    Route::post('delete-account', [\App\Http\Controllers\Api\Auth\AuthController::class, 'delete_account']);

    Route::prefix('reset')->group(function () {
        Route::post('forgot-password', [\App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'forgotPassword']);
        Route::post('reset-password', [\App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'resetPassword'])->name('password.reset');
        Route::post('checkOtp', [\App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'checkOtp']);
    });
});

Route::group(['prefix' => 'patient/auth'], function () {

    Route::get('my_personal_data', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'my_personal_data']);
    Route::post('update_my_personal_data', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'update_my_personal_data']);
    Route::get('signs', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'signs']);
    Route::post('update_signs', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'update_signs']);
    Route::get('medical_operations', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'medical_operations']);
    Route::get('chronic_diseases', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'chronic_diseases']);
    Route::get('patient_chronic_diseases_operations', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'patient_chronic_diseases_operations']);
    Route::post('add_patient_chronic_diseases_operations', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'add_patient_chronic_diseases_operations']);

    Route::get('patient_analysis', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'patient_analysis']);
    Route::get('patient_radiology', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'patient_radiology']);

    Route::get('insurance_companies', [\App\Http\Controllers\Api\Patient\InsuranceCompanyController::class, 'index']);

    Route::get('patient_chronic_diseases', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'patient_chronic_diseases']);
    Route::post('add_chronic_diseases', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'add_chronic_diseases']);

    Route::get('patient_medical_operations', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'patient_medical_operations']);
    Route::post('add_medical_operations', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'add_medical_operations']);


    Route::middleware('ApiLogin')->group(function () {
        Route::get('medical_bags', [\App\Http\Controllers\Api\Patient\MedicalBagController::class, 'index']);
        Route::post('medical_bag_store', [\App\Http\Controllers\Api\Patient\MedicalBagController::class, 'store']);

        Route::get('medical_file', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'index']);
        Route::post('medical_file_update', [\App\Http\Controllers\Api\Patient\MedicalFileController::class, 'update']);




        Route::get('laboratories_by_category', [\App\Http\Controllers\Api\Patient\LaboratoryController::class, 'index']);
        Route::get('laboratory_details', [\App\Http\Controllers\Api\Patient\LaboratoryController::class, 'show']);

        Route::get('packages', [\App\Http\Controllers\Api\Patient\PackageController::class, 'index']);
        Route::post('package_subscribe', [\App\Http\Controllers\Api\Patient\PackageController::class, 'subscribe']);

        ### BOOKING
        Route::post('make_booking', [\App\Http\Controllers\Api\Patient\BookingController::class, 'make_booking']);
        Route::post('make_booking_for_relative', [\App\Http\Controllers\Api\Patient\BookingController::class, 'make_booking_for_relative']);


        Route::get('relatives', [\App\Http\Controllers\Api\Patient\RelativeController::class, 'relatives']);

        Route::post('add_relative', [\App\Http\Controllers\Api\Patient\RelativeController::class, 'add_relative']);
        Route::post('update_relative', [\App\Http\Controllers\Api\Patient\RelativeController::class, 'update_relative']);
        Route::post('delete_relative', [\App\Http\Controllers\Api\Patient\RelativeController::class, 'delete_relative']);



        Route::get('bookings', [\App\Http\Controllers\Api\Patient\BookingController::class, 'bookings']);
        Route::get('get_agora_room', [\App\Http\Controllers\Api\Patient\BookingController::class, 'get_agora_room']);
        Route::get('patient_join_call', [\App\Http\Controllers\Api\Doctor\AgoraController::class, 'patient_join_call']);


        Route::get('booking_replay', [\App\Http\Controllers\Api\Patient\BookingController::class, 'booking_replay']);



        Route::post('make_request_booking', [\App\Http\Controllers\Api\Patient\RequestBookingController::class, 'make_request_booking']);


        ### Specialization Booking
        Route::post('make_specialization_booking', [\App\Http\Controllers\Api\Patient\SpecializationBookingController::class, 'make_booking']);
        Route::post('make_provider_specialization_booking', [\App\Http\Controllers\Api\Patient\SpecializationBookingController::class, 'make_provider_specialization_booking']);

        ### Favorite
        Route::post('add_favorite', [\App\Http\Controllers\Api\Patient\FavoriteController::class, 'add_favorite']);
        Route::get('list_favorite', [\App\Http\Controllers\Api\Patient\FavoriteController::class, 'list_favorite']);
        Route::post('delete_favorite', [\App\Http\Controllers\Api\Patient\FavoriteController::class, 'delete_favorite']);

        ### Delete Account


    });


});


Route::group(['prefix' => 'doctor/auth'], function () {


    Route::middleware('ApiDoctorLogin')->group(function () {

        Route::get('bookings', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'index']);

        Route::post('accept_booking', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'accept_booking']);

        Route::get('booking_details', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'booking_details']);

        Route::post('make_replying', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_replying']);
        Route::post('make_new_replying', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_new_replying']);
        Route::post('make_replying_laboratory', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_replying_laboratory']);
        Route::post('make_replying_radiology_center', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_replying_radiology_center']);
        Route::post('make_replying_pharmacy', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_replying_pharmacy']);
        Route::post('make_replying_diagnoses', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_replying_diagnoses']);

        Route::post('delele_replying_diagnoses', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'delete_replying_diagnoses']);

        Route::get('show_replying_laboratory', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'show_replying_laboratory']);
        Route::get('show_replying_pharmacy', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'show_replying_pharmacy']);
        Route::get('show_replying_radiology_center', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'show_replying_radiology_center']);
        Route::get('show_replying_diagnoses', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'show_replying_diagnoses']);
        Route::get('show_replying', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'show_replying']);



        Route::post('end_booking', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'end_booking']);


        Route::post('make_agora_room', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'make_agora_room']);


        Route::get('select_providers', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'select_providers']);



        Route::get('doctor_start_call', [\App\Http\Controllers\Api\Doctor\AgoraController::class, 'doctor_start_call']);

        ###Online Doctors
        Route::get('online_doctors', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'online_doctors']);

        ### Doctor Rebooking For Another Doctor

        Route::post('doctor_rebooking', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'doctor_rebooking']);


    });


});


Route::group(['prefix' => 'settings'], function () {

    Route::get('settings', [\App\Http\Controllers\Api\Setting\HoneController::class, 'settings']);
    Route::get('replay_pdf', [\App\Http\Controllers\Api\Setting\HoneController::class, 'replay_pdf']);

    Route::get('provider_types', [\App\Http\Controllers\Api\Setting\ProviderTypeController::class, 'provider_types']);



    Route::get('governorates', [\App\Http\Controllers\Api\Setting\CityController::class, 'governorates']);
    Route::get('cities_by_governorate', [\App\Http\Controllers\Api\Setting\CityController::class, 'cities_by_governorate']);

    Route::get('cities', [\App\Http\Controllers\Api\Setting\CityController::class, 'index']);
    Route::get('nationalities', [\App\Http\Controllers\Api\Setting\NationalityController::class, 'index']);
    Route::get('main_services', [\App\Http\Controllers\Api\Setting\MainServiceController::class, 'index']);
    Route::get('sliders', [\App\Http\Controllers\Api\Setting\HoneController::class, 'sliders']);
    Route::get('specializations', [\App\Http\Controllers\Api\Setting\HoneController::class, 'specializations']);
    Route::get('specialization_popular_doctors', [\App\Http\Controllers\Api\Setting\HoneController::class, 'specialization_popular_doctors']);
    Route::get('categories', [\App\Http\Controllers\Api\Setting\CategoryController::class, 'index']);
    Route::get('doctors_by_category', [\App\Http\Controllers\Api\Setting\DoctorController::class, 'doctors_by_category']);
    Route::get('doctor_details', [\App\Http\Controllers\Api\Setting\DoctorController::class, 'doctor_details']);
    Route::get('get_popular', [\App\Http\Controllers\Api\Setting\DoctorController::class, 'get_popular']);
    Route::get('fliter_doctor', [\App\Http\Controllers\Api\Setting\DoctorController::class, 'fliter_doctor']);
    Route::get('specialization_doctors', [\App\Http\Controllers\Api\Setting\HoneController::class, 'specialization_doctors']);

    ### Provider Regions
    Route::get('provider_regions', [\App\Http\Controllers\Api\Setting\ProviderController::class, 'provider_regions']);

    ### Provider region Data
    Route::get('provider_region_data', [\App\Http\Controllers\Api\Setting\ProviderController::class, 'provider_region_data']);

    ### Provider Data

    Route::get('provider_data', [\App\Http\Controllers\Api\Setting\ProviderController::class, 'provider_data']);

    ### show Patient Profile
    Route::get('show_patient_profile', [\App\Http\Controllers\Api\Setting\ProfileController::class, 'show_patient_profile']);

    ### show Doctor Profile
    Route::get('show_doctor_profile', [\App\Http\Controllers\Api\Setting\ProfileController::class, 'show_doctor_profile']);

    ### provider type
    Route::get('provider_type',  [\App\Http\Controllers\Api\Setting\ProviderTypeController::class, 'provider_type']);

    Route::get('providers', [\App\Http\Controllers\Api\Setting\ProviderTypeController::class, 'providers']);

    ### Hospitals
    Route::get('hospitals', [\App\Http\Controllers\Api\Setting\HospitalController::class, 'hospitals']);

    ### Delete Account
    Route::get('delete_account', [\App\Http\Controllers\Api\Setting\ProfileController::class, 'delete_account']);


    ### diagnoses
    Route::get('diagnoses', [\App\Http\Controllers\Api\Doctor\DiagnosesController::class, 'diagnoses']);
    Route::get('medication_units', [\App\Http\Controllers\Api\Doctor\DiagnosesController::class, 'medication_units']);
    Route::get('solution_types', [\App\Http\Controllers\Api\Doctor\DiagnosesController::class, 'solution_types']);
    Route::get('medication_ways', [\App\Http\Controllers\Api\Doctor\DiagnosesController::class, 'medication_ways']);
    Route::get('solution_priorities', [\App\Http\Controllers\Api\Doctor\DiagnosesController::class, 'solution_priorities']);
    Route::get('notifications', [\App\Http\Controllers\Api\Notification\NotificationController::class, 'index']);
    Route::get('notification_details', [\App\Http\Controllers\Api\Notification\NotificationController::class, 'notification_details']);



    ### complete bookings
    Route::get('complete_bookings', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'complete_bookings']);

    Route::get('booking_replay_by_patient_id', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'booking_replay_by_patient_id']);

    ### contact

    Route::post('contact', [\App\Http\Controllers\Api\Setting\ContactController::class, 'index']);

    Route::get('test', [\App\Http\Controllers\Api\Doctor\BookingController::class, 'test']);



    Route::get('test_test', [\App\Http\Controllers\Api\Notification\NotificationController::class, 'test_test']);


    Route::post('/fawry/payment/initiate', [\App\Http\Controllers\Api\FawryApiController::class, 'initiatePayment']);
    Route::post('/fawry-callback', [\App\Http\Controllers\Api\FawryApiController::class, 'handleCallback']);


});

Route::group(['prefix' => 'general'], function () {
    Route::apiResource('otp-providers', \App\Http\Controllers\Api\General\MainOtpProviderController::class);
});
