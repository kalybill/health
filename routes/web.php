<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccessTypeController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MedicalRecordsController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\NurseUserController;
use App\Http\Controllers\OrderTypeController;
use App\Http\Controllers\ReferralSourceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitTypeController;
use App\Models\Case_type;
use App\Models\Nurse_geographical;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::middleware(['auth', 'is_User'])->group(function(){
// //Nurse
//     Route::get('nurse-user', [NurseUserController::class,'nurse_user'])->name('user.nurse');
// });

Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::post('search_area_rn', [DashboardController::class, 'search_area_rn']);
    Route::get('nurses_list', [NurseController::class, 'nurses_list']);

    //Calender
    Route::post('save-cal-event', [CalenderController::class, 'save_cal_event']);
    Route::get('get_dates_cal', [CalenderController::class, 'get_dates_cal']);
    Route::delete('/delete_cal/{id}', [CalenderController::class, 'delete_cal']);

    //Patient
    Route::prefix('patient')->group(function () {
        Route::get('index', [PatientController::class, 'index']);
        Route::get('dt_patient', [PatientController::class, 'dt_patient']);
        Route::get('dt_schedules', [PatientController::class, 'dt_schedules']);
        Route::get('edit-patient/{id}', [PatientController::class, 'edit_patient']);
        Route::post('save-patient', [PatientController::class, 'save_patient']);
        Route::post('save-service', [PatientController::class, 'save_service']);
        Route::post('save-phyinfo', [PatientController::class, 'save_phyinfo']);
        Route::post('save-payor', [PatientController::class, 'save_payor']);
        Route::get('schedules', [PatientController::class, 'schedules']);
        Route::get('edit-schedules/{id}', [PatientController::class, 'edit_schedules']);
        Route::post('save-schedule', [PatientController::class, 'save_schedule']);
        Route::post('save-progressnote', [PatientController::class, 'save_progressnote']);
        Route::post('save-neworder', [PatientController::class, 'save_neworder']);
        Route::get('dt_scheduling/{id}', [PatientController::class, 'dt_scheduling']);
        Route::get('dt_progress/{id}', [PatientController::class, 'dt_progress']);
        Route::get('dt_addnote/{id}', [PatientController::class, 'dt_addnote']);
        Route::post('edit_schedule', [PatientController::class, 'edit_schedule']);
        Route::post('edit_progress', [PatientController::class, 'edit_progress']);
        Route::post('edit_note', [PatientController::class, 'edit_note']);
        Route::post('update-schedule', [PatientController::class, 'update_schedule']);
        Route::post('update-progressnote', [PatientController::class, 'update_progressnote']);
        Route::post('update_neworder', [PatientController::class, 'update_neworder']);
        Route::post('patient-delete', [PatientController::class, 'delete']);
        Route::post('delete_schedule', [PatientController::class, 'delete_schedule']);
        Route::post('delete_progress', [PatientController::class, 'delete_progress']);
        Route::post('delete_new', [PatientController::class, 'delete_new']);
        Route::post('save_onboarding', [PatientController::class,'save_onboarding']);
        Route::get('discharge', [PatientController::class,'discharge']);
        Route::get('long-term', [PatientController::class,'long_term']);
        Route::get('specialty-infusion', [PatientController::class,'specialty_infusion']);
        Route::get('dt_patient_discharged', [PatientController::class,'dt_patient_discharged']);
        Route::get('dt_long_term', [PatientController::class,'dt_long_term']);
        Route::get('dt_specialty_infusion', [PatientController::class,'dt_specialty_infusion']);
    });

    //Account
    Route::prefix('account')->group(function () {
        Route::get('index', [AccountController::class, 'index']);
    });


    //Reports
    Route::prefix('reports')->group(function () {
        Route::get('expired-credentail', [ReportController::class, 'expired_credentail']);
        Route::get('dt_credential_exp', [ReportController::class, 'dt_credential_exp']);
        Route::get('nurse-report', [ReportController::class, 'nurse_report']);
        Route::get('dt_nursereport', [ReportController::class, 'dt_nursereport']);
        Route::get('note-by-nurse', [ReportController::class, 'note_by_nurse']);
        Route::get('dt_out_nurse_report', [ReportController::class, 'dt_out_nurse_report']);
        Route::post('/searchByNurse', [ReportController::class, 'searchByNurse']);
        Route::post('/searchByPhama', [ReportController::class, 'searchByPhama']);
        Route::post('/searchByPatient', [ReportController::class, 'searchByPatient']);
        Route::get('/single-nurse-report/{id}', [ReportController::class, 'single_nurse_report']);
        Route::get('/single-patient-report/{id}', [ReportController::class, 'single_patient_report']);
        Route::get('/single-client-report/{id}', [ReportController::class, 'single_client_report']);
        Route::get('dt_single_nurse_report/{id}', [ReportController::class, 'dt_single_nurse_report']);
        Route::post('view-md-records', [ReportController::class, 'view_md_records']);
        Route::get('out-by-phama', [ReportController::class, 'out_by_phama']);
        Route::get('dt_out_phama', [ReportController::class, 'dt_out_phama']);
        Route::get('out-by-patient', [ReportController::class, 'out_by_patient']);
        Route::get('visit-report', [ReportController::class, 'visit_report']);
        Route::get('dt_visit_rn_report', [ReportController::class, 'dt_visit_rn_report']);
        Route::post('get_visit_date', [ReportController::class, 'get_visit_date']);
        Route::get('billing-report', [ReportController::class, 'billing_report']);
        Route::post('get_md_billings_reports', [ReportController::class, 'get_md_billings_reports']);
        Route::get('patient-auth-report', [ReportController::class, 'patient_auth_report']);
        Route::get('dt_auth_report', [ReportController::class, 'dt_auth_report']);
        Route::get('view-patient-auth/{id}', [ReportController::class, 'view_patient_auth']);
        Route::get('specialty-infusion-nurse', [ReportController::class, 'specialty_infusion_nurse']);
        Route::get('dt_specialty_inf', [ReportController::class, 'dt_specialty_inf']);
        Route::get('specialty-infusion-rx', [ReportController::class, 'specialty_infusion_rx']);
        Route::get('dt_specialty_inf_rx', [ReportController::class, 'dt_specialty_inf_rx']);
        Route::get('dt_specialty_infusion_patient_visit', [ReportController::class, 'dt_specialty_infusion_patient_visit']);
        Route::get('specialty-infusion-patient-visit', [ReportController::class, 'specialty_infusion_patient_visit']);
        Route::get('weekly-visit-rx', [ReportController::class, 'weekly_visit_rx']);
        Route::get('dt_weekly_visit_rx', [ReportController::class, 'dt_weekly_visit_rx']);
    });

    //Settings
    Route::prefix('settings')->group(function(){
        Route::get('access-type', [AccessTypeController::class,'index']);
        Route::post('access-type', [AccessTypeController::class,'save_access_type']);
        Route::get('dt_access_types', [AccessTypeController::class,'dt_access_types']);
        Route::post('edit_access_type', [AccessTypeController::class,'edit_access_type']);
        Route::post('update_access_type', [AccessTypeController::class,'save_update']);
        Route::post('access-delete', [AccessTypeController::class,'delete']);
        Route::get('find_single_item', [AccessTypeController::class,'find_single_item']);

        //Pupms
        Route::get('pumps', [PumpController::class,'index']);
        Route::post('pump', [PumpController::class,'save_pump']);
        Route::get('dt_pump', [PumpController::class,'dt_pump']);
        Route::post('edit_pump', [PumpController::class,'edit_pump']);
        Route::post('update_pump', [PumpController::class,'save_update']);
        Route::get('find_single_item_pump', [PumpController::class,'find_single_item']);
        Route::post('pump-delete', [PumpController::class,'delete']);

        //Order Types
        Route::get('order-type', [OrderTypeController::class,'index']);
        Route::post('order_type', [OrderTypeController::class,'save_order_type']);
        Route::get('dt_order_type', [OrderTypeController::class,'dt_order_type']);
        Route::post('edit_order_type', [OrderTypeController::class,'edit_order_type']);
        Route::post('update_order_type', [OrderTypeController::class,'save_update']);
        Route::get('find_single_item_order_type', [OrderTypeController::class,'find_single_item']);
        Route::post('order_type-delete', [OrderTypeController::class,'delete']);

        //Referrals
        Route::get('referral-source', [ReferralSourceController::class,'index']);
        Route::post('referral-source', [ReferralSourceController::class,'save_referral_source']);
        Route::get('dt_referral_source', [ReferralSourceController::class,'dt_referral_source']);
        Route::post('edit_referral_source', [ReferralSourceController::class,'edit_referral_source']);
        Route::post('update_referral_source', [ReferralSourceController::class,'save_update']);
        Route::get('find_single_item_referral_source', [ReferralSourceController::class,'find_single_item']);
        Route::post('referral_source_delete', [ReferralSourceController::class,'delete']);


        //Service Type
        Route::get('service-type', [ServiceTypeController::class,'index']);
        Route::get('dt_service_type', [ServiceTypeController::class,'dt_service_type']);
        Route::post('edit_service_type', [ServiceTypeController::class,'edit_service_type']);
        Route::post('service-type', [ServiceTypeController::class,'save_service_type']);
        Route::post('update_service_type', [ServiceTypeController::class,'save_update']);
        Route::get('find_single_item_service_type', [ServiceTypeController::class,'find_single_item']);
        Route::post('referral_service_type', [ServiceTypeController::class,'delete']);

        //Case Type
        Route::get('case-type', [CaseTypeController::class,'index']);
        Route::get('dt_case_type', [CaseTypeController::class,'dt_case_type']);
        Route::post('edit_case_type', [CaseTypeController::class,'edit_case_type']);
        Route::post('case-type', [CaseTypeController::class,'save_case_type']);
        Route::post('update_case_type', [CaseTypeController::class,'save_update']);
        Route::get('find_single_item_case_type', [CaseTypeController::class,'find_single_item']);
        Route::post('referral_case_type', [CaseTypeController::class,'delete']);

        //Language
        Route::get('language', [LanguageController::class,'index']);
        Route::get('dt_language', [LanguageController::class,'dt_language']);
        Route::post('edit_language', [LanguageController::class,'edit_language']);
        Route::post('save_language', [LanguageController::class,'save_language']);
        Route::post('save_update', [LanguageController::class,'save_update']);
        Route::get('find_single_item', [LanguageController::class,'find_single_item']);
        Route::post('delete_language', [LanguageController::class,'delete']);


        //Document
        Route::get('document', [DocumentController::class,'index']);
        Route::get('dt_document', [DocumentController::class,'dt_document']);
        Route::post('edit_document', [DocumentController::class,'edit_document']);
        Route::post('save_document', [DocumentController::class,'save_document']);
        Route::post('save_update', [DocumentController::class,'save_update']);
        Route::get('find_single_item', [DocumentController::class,'find_single_item']);
        Route::post('delete_document', [DocumentController::class,'delete']);
        

        //Clients
        Route::get('clients', [ClientController::class, 'index']);
        Route::post('save_client', [ClientController::class, 'save_client']);
        Route::get('dt_clients', [ClientController::class, 'dt_clients']);
        Route::get('dt_clients_contact/{id}', [ClientController::class, 'dt_clients_contact']);
        Route::get('edit_clients/{id}', [ClientController::class, 'edit_clients']);
        Route::post('update_client', [ClientController::class, 'update_client']);
        Route::post('save_contact_client', [ClientController::class, 'save_contact_client']);

        //Visit Type
        Route::get('visit-type', [VisitTypeController::class, 'index']);
        Route::post('visit', [VisitTypeController::class,'save_visit']);
        Route::get('dt_visit', [VisitTypeController::class,'dt_visit']);
        Route::post('edit_visit', [VisitTypeController::class,'edit_visit']);
        Route::post('update_visit', [VisitTypeController::class,'save_update']);
        Route::get('find_single_item_visit', [VisitTypeController::class,'find_single_item']);
        Route::post('visit-delete', [VisitTypeController::class,'delete']);


        //Users 
        Route::get('users',[UserController::class,'index']);
        Route::post('save_user', [UserController::class, 'save_user']);
        Route::get('dt_user', [UserController::class, 'dt_user']);
        Route::post('edit_user', [UserController::class,'edit_user']);
        Route::post('update_user', [UserController::class,'save_update']);
        Route::get('find_single_item_user', [UserController::class,'find_single_item']);
        Route::post('user-delete', [UserController::class,'delete']);
    });

    Route::prefix('nurse')->group(function(){
        //Nurse 
        Route::get('nurse', [NurseController::class, 'index']);
        Route::post('nurse', [NurseController::class, 'save_nurse']);
        Route::get('dt_nurse', [NurseController::class, 'dt_nurse']);
        Route::post('edit_nurse', [NurseController::class, 'edit_nurse']);
        Route::post('update_nurse', [NurseController::class, 'update_nurse']);
        Route::get('find_single_nurse', [NurseController::class, 'find_single_nurse']);
        Route::post('nurse-delete', [NurseController::class,'delete']);
        Route::get('credential-tracking/{id}', [NurseController::class,'credential_tracking']);
        Route::get('add-nurse', [NurseController::class,'add_nurse']);
        Route::post('save_credential', [NurseController::class,'save_credential']);
        Route::get('dt_credential_tracking/{id}', [NurseController::class,'dt_credential_tracking']);
        Route::post('edit_credentails', [NurseController::class,'edit_credentails']);
        Route::post('update_credential', [NurseController::class,'update_credential']);
        Route::get('geo-area/{id}', [NurseController::class, 'geo_area']);
        Route::post('save_area', [NurseController::class, 'save_area']);
    });


    Route::prefix('medrecords')->group(function(){
        Route::get('notes', [MedicalRecordsController::class, 'notes']);
        Route::get('dt_notes', [MedicalRecordsController::class, 'dt_notes']);
        Route::post('get_md_records', [MedicalRecordsController::class, 'get_md_records']);
        Route::post('save_record', [MedicalRecordsController::class, 'save_record']);
        Route::get('billing', [MedicalRecordsController::class, 'billing']);
        Route::get('dt_billing', [MedicalRecordsController::class, 'dt_billing']);
        Route::post('get_md_billings', [MedicalRecordsController::class, 'get_md_billings']);
        Route::post('save_billing', [MedicalRecordsController::class, 'save_billing']);
        Route::get('untransferred-visit', [MedicalRecordsController::class, 'untransferred_visit']);
        Route::get('untransferred-visit-no-process-date', [MedicalRecordsController::class, 'untransferred_visit_no_process_date']);
        Route::get('dt_untransfeered', [MedicalRecordsController::class, 'dt_untransfeered']);
        Route::get('dt_untransfeered_no_date', [MedicalRecordsController::class, 'dt_untransfeered_no_date']);

    });


    // Route::prefix('nurse')->group(function(){
    //     Route::get('nurse', [NurseController::class, 'index']);
    //     Route::post('nurse', [NurseController::class, 'save_nurse']);
    //     Route::get('dt_nurse', [NurseController::class, 'dt_nurse']);
    //     Route::post('edit_nurse', [NurseController::class, 'edit_nurse']);
    //     Route::post('update_nurse', [NurseController::class, 'update_nurse']);
    //     Route::get('find_single_nurse', [NurseController::class, 'find_single_nurse']);
    //     Route::post('nurse-delete', [NurseController::class,'delete']);
    // });


    //Referrals
    Route::get('referrals', [ReferralController::class,'index']);
    Route::post('referrals', [ReferralController::class,'save_referrals']);
    Route::get('dt_referrals', [ReferralController::class,'dt_referrals']);
    Route::get('find_single_referral', [ReferralController::class,'find_single_referral']);
    Route::post('referral-delete', [ReferralController::class,'delete']);
    Route::post('edit_referrals', [ReferralController::class,'edit_referrals']);
    Route::post('update_referrals', [ReferralController::class,'update_referrals']);
    Route::post('get-clients', [ReferralController::class,'get_clients']);

    //Change Password
    Route::get('edit-profile',[UserController::class,'edit_profile']);
    Route::post('edit_profile',[UserController::class,'save_profile']);
});


require __DIR__ . '/auth.php';
