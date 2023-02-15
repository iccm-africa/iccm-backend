<?php

use App\Http\Controllers\DynamicPageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/schedule', function () {
	return view('schedule');
})->name('schedule');

Route::get('/directions', function () {
    return view('directions');
})->name('directions');

Route::get('/registration', function () {
    return view('registration', ['accommodations' => \App\Accommodation::all(), 'def' => \App\Currency::def()]);
})->name('registration');

Route::get('/visa', function () {
    return view('visa');
})->name('visa');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/thanks-post', function() {
	return view('thanks-post');
})->name('thanks-post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/group/add', 'GroupController@addUser')->name('addUser');
Route::post('/group', 'GroupController@saveUser')->name('saveUser');
Route::get('/group/invoice/{uid}', 'GroupController@downloadInvoice')->name('downloadInvoice');
Route::get('/group/receipt/{uid}', 'GroupController@downloadReceipt')->name('downloadReceipt');
Route::get('/group/{uid?}', 'GroupController@index')->name('group');

/* Admin area routes */
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/users', 'AdminController@users')->name('admin.users');
Route::get('/admin/users/{id}', 'AdminController@user')->name('admin.user');
Route::get('/admin/groups', 'AdminController@groups')->name('admin.groups');
Route::get('/admin/groups/{id}', 'AdminController@group')->name('admin.group');
Route::get('/admin/invoices', 'AdminController@invoices')->name('admin.invoices');
Route::get('/admin/invoices/download/{uid}', 'AdminController@downloadInvoice')->name('admin.invoices.download');
Route::get('/admin/invoices/receipt/{uid}', 'AdminController@downloadReceipt')->name('admin.invoices.receipt');
Route::get('/admin/invoices/refresh/{id}', 'AdminController@refreshInvoiceConfirm')->name('admin.invoices.refreshConfirm');
Route::post('/admin/invoices/refresh', 'AdminController@refreshInvoice')->name('admin.invoices.refresh');
Route::get('/admin/invoices/pay/{id}', 'AdminController@payInvoiceConfirm')->name('admin.invoices.confirmPaid');
Route::post('/admin/invoices/pay/{id}', 'AdminController@payInvoice')->name('admin.invoices.pay');

Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::post('/checkout', 'CheckoutController@pay')->name('checkout_pay');
Route::get('/checkout/mollie/redirect/{uid}', 'CheckoutController@mollieRedirect')->name('mollie_redirect');
Route::get('/checkout/mollie/retry/{uid}', 'CheckoutController@mollieRetry')->name('mollie_retry');
Route::post('/postregistration', 'PostRegistrationController@store')->name('postregistration.store');
Route::put('/postregistration/mail/{id}', 'PostRegistrationController@update')->name('postregistration.update');
Route::get('postregistration/mail/{id}', 'PostRegistrationController@openMail')->name('postregistration_mail');
Route::get('postregistration/file/{path}', 'PostRegistrationController@file')->name('postregistration.file')->where('path', '(.*)');
Route::get('/invoice/{id}','GroupController@downloadPDF');
#Route::get('/postregistration', 'PostRegistrationController@index');
#Route::post('/postregistration', 'PostRegistrationController@saveForm')->name('saveForm');
#Route::get('/postregistration', 'PostRegistrationController@index');
#Route::get('/postregistration', 'PostRegistrationController@edit')->name('editform');
Route::resource('/dynamicPages', DynamicPageController::class);
Route::get('/showPage/{id}', [DynamicPageController::class, 'showPage'])->name('showPage');


