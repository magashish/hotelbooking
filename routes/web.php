<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//Auth::routes();
Auth::routes(['register' => false]);


Route::middleware('admin')->group(function () {

    Route::get('/user/admin', [App\Http\Controllers\UsersController::class, 'useradmin'])->name('user.useradmin');
    Route::get('/user/owner', [App\Http\Controllers\UsersController::class, 'userowner'])->name('user.userowner');
    Route::get('/user/cleaner', [App\Http\Controllers\UsersController::class, 'usercleaner'])->name('user.usercleaner');

    Route::get('/user/owner/create', [App\Http\Controllers\UsersController::class, 'ownercreate'])->name('user.ownercreate');
    Route::get('/user/owner/edit/{id}', [App\Http\Controllers\UsersController::class, 'editowneruser'])->name('user.editowneruser');
    Route::get('/user/owner/show/{id}', [App\Http\Controllers\UsersController::class, 'ownershow'])->name('user.ownershow');
    Route::post('/owner/update/{id}', [App\Http\Controllers\UsersController::class, 'admin_user_update'])->name('admin.admin_user_update'); 

    Route::get('/user/cleaner/create', [App\Http\Controllers\UsersController::class, 'cleanercreate'])->name('user.cleanercreate');
    Route::get('/user/cleaner/edit/{id}', [App\Http\Controllers\UsersController::class, 'editcleaner'])->name('user.editcleaner');
    Route::post('/cleaner/update/{id}', [App\Http\Controllers\UsersController::class, 'cleaner_user_update'])->name('admin.cleaner_user_update'); 
    Route::resource('user', App\Http\Controllers\UsersController::class);

    Route::resource('unit', App\Http\Controllers\UnitController::class);
    Route::get('/unit/create/{ownerid}/{unitid?}', [App\Http\Controllers\UnitController::class, 'create_unit'])->name('admin.create_unit');
    Route::get('/owner/unit/{id}', [App\Http\Controllers\UnitController::class, 'owner_unit'])->name('user.owner_unit');

    Route::get('services/calendar', [App\Http\Controllers\ServiceController::class, 'services_calendar'])->name('services.services_calendar'); 
    Route::get('/calendarAjaxData', [App\Http\Controllers\ServiceController::class, 'calendarAjaxData'])->name('services.calendarAjaxData');

    Route::post('calendarAjax', [App\Http\Controllers\ServiceController::class, 'services_ajax']);/************** Need to check this one to delete***********************/
    Route::get('/service/calendar/edit/{id}/', [App\Http\Controllers\ServiceController::class, 'services_calendar_edit'])->name('services.services_calendar_edit'); 

    Route::get('/assigncleaners/{unitid?}', [App\Http\Controllers\ServiceController::class, 'services_assigncleaners'])->name('services.services_assigncleaners'); 
    Route::get('/assign/cleaner/{unitid?}', [App\Http\Controllers\ServiceController::class, 'assigncleaner'])->name('services.assigncleaner');
    // Route::post('/cleaner/update/{unitid}', [App\Http\Controllers\ServiceController::class, 'cleanerupdate'])->name('services.cleanerupdate');  

   
    Route::get('/services/create/{unit}', [App\Http\Controllers\ServiceController::class, 'admin_create_date'])->name('admin.admin_create_date');
    Route::get('services/unit/{id}', [App\Http\Controllers\ServiceController::class, 'get_date'])->name('admin.get_date');
    Route::get('oldservices/', [App\Http\Controllers\ServiceController::class, 'get_old_services'])->name('admin.get_old_services');
    Route::get('oldservices/unit/{id}', [App\Http\Controllers\ServiceController::class, 'get_old_services_by_unit'])->name('admin.get_old_services_by_unit');
    Route::resource('services', App\Http\Controllers\ServiceController::class); 
    Route::get('/manage', [App\Http\Controllers\HomeController::class, 'manage'])->name('home.manage');


    Route::resource('contactowner', App\Http\Controllers\ContactOwnerController::class);    
    Route::resource('assigncleaner', App\Http\Controllers\CleanersInformationSchedule::class);









    
});

Route::middleware('owner')->group(function () {

    Route::get('/owner-services/create/{id}', [App\Http\Controllers\Owner\ServiceController::class, 'owner_create_date'])->name('owner.owner_create_date'); 
    Route::get('/owner-services/service/{id?}', [App\Http\Controllers\Owner\ServiceController::class, 'owner_get_date'])->name('owner.owner_get_date');
    Route::get('/owner-services/edit/{id?}', [App\Http\Controllers\Owner\ServiceController::class, 'owner_edit_date'])->name('owner.owner_edit_date');
    //Route::get('/owner-services/service/view/{id?}', [App\Http\Controllers\Owner\ServiceController::class, 'show'])->name('owner.owner_show_date');
    Route::resource('owner-services', App\Http\Controllers\Owner\ServiceController::class);

    Route::get('/home/accountinfo', [App\Http\Controllers\UsersController::class, 'owner_account_info'])->name('owner.owner_account_info');
    //Route::get('/owner/user/edit/{id}', [App\Http\Controllers\UsersController::class, 'owner_user_edit'])->name('services.owner_user_edit');  //// need to delete
    Route::post('/owner/user/update/{id}', [App\Http\Controllers\UsersController::class, 'user_update'])->name('owner.user_update'); 
    
    Route::get('/home/contactbclean', [App\Http\Controllers\Owner\ServiceController::class, 'owner_contact_bclean'])->name('owner.owner_contact_bclean');
    Route::post('/owner/user/contactbclean/', [App\Http\Controllers\Owner\ServiceController::class, 'post_contact_bclean'])->name('owner.post_contact_bclean'); 

    


});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
