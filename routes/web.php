<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterOptionsController;
use App\Http\Controllers\MasterQuestionController;
use App\Http\Controllers\MasterSubCategoryController;
use App\Http\Controllers\SubCategoryQuestionOptionMappingController;
use App\Models\MasterCategory;
use App\Models\MasterQuestion;
use App\Models\MasterSubCategory;
use App\Models\SubCategoryQuestionMapping;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Main.index');
});


// Category
Route::get('/admin/get-all/categories', [MasterCategoryController::class, 'getAllThroughAdmin'])->name('get.all-categories');
Route::post('/admin/create/category', [MasterCategoryController::class, 'createThroughAdmin'])->name('create.category');
Route::delete('/admin/delete/category', [MasterCategoryController::class, 'delete'])->name('delete.category');
Route::get('/admin/change/category/status', [MasterCategoryController::class, 'changeCategoryStatus'])->name('category.change.status');
Route::get('/admin/edit/category/{categoryId}',[MasterCategoryController::class,'edit'])->name('edit.ctageory');
Route::post('/admin/update/category/{categoryId}',[MasterCategoryController::class,'update'])->name('update.category');
// sub-category
Route::get('/admin/create-sub-category',[MasterSubCategoryController::class, 'getCategoriesData'])->name('get.create-category');
Route::get('/admin/get-all/sub-categories', [MasterSubCategoryController::class, 'getAllThroughAdmin'])->name('get.all-sub-categories');
Route::post('/admin/create/sub-category',[MasterSubCategoryController::class, 'create'])->name('create.sub-category');
Route::delete('/admin/delete/sub-category', [MasterSubCategoryController::class, 'delete'])->name('delete.sub-category');
Route::get('/admin/change/sub-category/status', [MasterSubCategoryController::class, 'changeSubCategoryStatus'])->name('sub-category.change.status');
Route::get('/admin/edit/sub-category/{categoryId}',[MasterSubCategoryController::class, 'edit'])->name('edit.sub-category');
Route::post('/admin/update/sub-category/{categoryId}',[MasterCategoryController::class, 'update'])->name('update.sub-category');
// Question
Route::get('/admin/get-all/questions',[MasterQuestionController::class,'getAllThroughAdmin'])->name('get.questions');
Route::get('/admin/change/question/status', [MasterQuestionController::class, 'changeQuestionStatus'])->name('question.change.status');
Route::post('/admin/create/questions',[MasterQuestionController::class,'createThroughAdmin'])->name('create.questions');
Route::delete('/admin/delete/question',[MasterQuestionController::class,'delete'])->name('delete.question');
//options
Route::get('/admin/get-all/options',[MasterOptionsController::class,'getAllThroughAdmin'])->name('get.options');
Route::get('/admin/change/option/status', [MasterOptionsController::class, 'changeOptionStatus'])->name('option.change.status');
Route::post('/admin/create/option',[MasterOptionsController::class,'createThroughAdmin'])->name('create.options');
Route::delete('/admin/delete/option',[MasterOptionsController::class,'delete'])->name('delete.option');

// Category question option mapping
Route::get('/admin/get/create-page',[SubCategoryQuestionOptionMappingController::class,'getSubCategoryQuestionAndOptionForCreate'])->name('get.create-mapping-data');


Route::get('/admin/dashboard', function () {
    return view('Admin.dashboard');
});


Route::post('/contact-us', [ContactUsController::class, 'createContactUs'])->name('store.contact-us');



Route::get('/admin/request-completed', function () {
    return view('admin.Request.request-list-completed');
});


Route::get('/admin/contact', function () {
    return view('admin.User.contact');
});


Route::get('/admin/facilities', function () {
    return view('admin.Facilities.facilities');
});


Route::get('/admin/facilities-create', function () {
    return view('admin.Facilities.facilities-create');
});


Route::get('/admin/aboutus-create', function () {
    return view('admin.AboutUs.aboutus-create');
});


Route::get('/admin/about-us', function () {
    return view('admin.AboutUs.aboutus');
});


Route::get('/admin/feedback', function () {
    return view('admin.User.feedback');
});


Route::get('/admin/services', function () {
    return view('admin.Service.service-list');
});

Route::get('/admin/service-create', function () {
    return view('admin.Service.service-create');
});

Route::get('/admin/service-edit', function () {
    return view('admin.Service.service-edit');
});


Route::get('/admin/login', function () {
    return view('admin.login');
});


Route::get('/admin/doctor-list', function () {
    return view('Admin.Doctor.doctor-list');
});


Route::get('/admin/patient-list', function () {
    return view('Admin.Patient.patient-list');
});




Route::get('/admin/category', function () {
    return view('Admin.Category.category-create');
});

Route::get('/admin/category-list', function () {
    return view('Admin.Category.category-list');
});

Route::get('/admin/category-edit', function () {
    return view('Admin.Category.category-edit');
});





Route::get('/admin/sub-category', function () {
    return view('Admin.SubCategory.sub-category-create');
});

Route::get('/admin/sub-category-list', function () {
    return view('Admin.SubCategory.sub-category-list');
});


Route::get('/admin/questions', function () {
    return view('Admin.Questions.questions-create');
});


Route::get('/admin/questions-edit', function () {
    return view('Admin.Questions.questions-edit');
});


Route::get('/admin/questions-list', function () {
    return view('Admin.Questions.questions-list');
});




Route::get('/admin/options', function () {
    return view('Admin.Options.options-create');
});


Route::get('/admin/options-list', function () {
    return view('Admin.Options.options-list');
});


Route::get('/admin/options-edit', function () {
    return view('Admin.Options.options-edit');
});





Route::get('/admin/mapping', function () {
    return view('Admin.Mapping.mapping-create');
});

Route::get('/admin/mapping-list', function () {
    return view('Admin.Mapping.mapping-list');
});


Route::get('/admin/mapping-edit', function () {
    return view('Admin.Mapping.mapping-edit');
});


Route::get('/admin/doctor-list', function () {
    return view('Admin.Doctor.doctor-list');
});
