<?php

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

Route::get('/help', function () {
    return view('help');
})->name('help');


Route::namespace('Auth')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->middleware('guest')->name('login');
    Route::post('/login', 'LoginController@login')->middleware('guest');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/getStaffPosition', 'HomeController@getStaffPosition');
    Route::get('/home/getStaffDepartement', 'HomeController@getStaffDepartement');

    //personal karyawan
    Route::get('/users/account/{id}/edit', 'UsersController@editAccount')->name('users.account.edit');
    Route::patch('/users/{id}/updateAccount', 'UsersController@updateAccount')->name('users.account.update');
    // profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/{id}/edit', 'ProfileController@editProfile')->name('profile.edit');
    Route::patch('/profile/{id}/update', 'ProfileController@updateProfile')->name('profile.update');
    Route::patch('/profile/upload', 'ProfileController@uploadPhoto')->name('profile.upload');

    Route::middleware('role:admin|superadmin')->group(function () {
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::patch('/users/{id}/update', 'UsersController@update')->name('users.update');
        Route::get('/users/{id}', 'UsersController@destroy')->name('users.destroy');

        Route::get('/roles', 'RolesController@index')->name('roles.index');
        Route::get('/roles/create', 'RolesController@create')->name('roles.create');
        Route::post('/roles', 'RolesController@store')->name('roles.store');
        Route::get('/roles/{roles}/edit', 'RolesController@edit')->name('roles.edit');
        Route::patch('/roles/{roles}/update', 'RolesController@update')->name('roles.update');
        Route::get('/roles/{id}', 'RolesController@destroy')->name('roles.destroy');
    });

    Route::middleware('role:admin|accounting|supervisor')->group(function () {
        Route::namespace('Master')->prefix('master')->name('master.')->group(function () {
            Route::get('position', 'PositionController@index')->name('position.index');
            Route::middleware('role:admin|accounting')->group(function () {
                Route::get('position/create', 'PositionController@create')->name('position.create');
                Route::post('position', 'PositionController@store')->name('position.store');
                Route::get('position/{position}/edit', 'PositionController@edit')->name('position.edit');
                Route::patch('position/{position}/update', 'PositionController@update')->name('position.update');
                Route::get('position/{id}', 'PositionController@destroy')->name('position.destroy');
            });

            Route::get('departement', 'DepartementController@index')->name('departement.index');
            Route::get('staff', 'StaffController@index')->name('staff.index');
            Route::middleware('role:admin|accounting')->group(function () {
                Route::get('departement/create', 'DepartementController@create')->name('departement.create');
                Route::post('departement', 'DepartementController@store')->name('departement.store');
                Route::get('departement/{departement}/edit', 'DepartementController@edit')->name('departement.edit');
                Route::patch('departement/{departement}/update', 'DepartementController@update')->name('departement.update');
                Route::get('departement/{id}', 'DepartementController@destroy')->name('departement.destroy');

                Route::get('staff/create', 'StaffController@create')->name('staff.create');
                Route::post('staff', 'StaffController@store')->name('staff.store');
                Route::get('staff/{staff}/edit', 'StaffController@edit')->name('staff.edit');
                Route::patch('staff/{staff}/update', 'StaffController@update')->name('staff.update');
                Route::get('staff/{id}', 'StaffController@destroy')->name('staff.destroy');
            });
        });

        Route::get('salary', 'SalaryController@index')->name('salary.index');
        Route::get('salary/detail/id={id}', 'SalaryController@show')->name('salary.show');
        Route::get('overtime', 'OvertimeController@index')->name('overtime.index');

        Route::middleware('role:admin|accounting')->group(function () {
            Route::get('salary/create', 'SalaryController@create')->name('salary.create');
            Route::post('salary/detail/create', 'SalaryController@store')->name('salary.store');
            Route::post('salary/detail/create/store', 'SalaryController@storeDetail')->name('salary.detail.store');
            Route::get('salary/detail/{salary}/edit', 'SalaryController@edit')->name('salary.edit');

            Route::patch('salary/{salary}/update', 'SalaryController@update')->name('salary.update');
            Route::get('staff/get_salary', 'SalaryController@getSalary');
            Route::get('salary/{id}', 'SalaryController@destroyDetail')->name('salary.destroyDetail');
            Route::get('salary/export/excel/id={id}/filter={filter}', 'SalaryController@excel')->name('salary.export.excel');
        });

        Route::middleware('role:admin|accounting')->group(function () {
            //kategori_lembur.show
            Route::get('kategori_lembur/create', 'kategori_lemburController@create')->name('kategori_lembur.create');
            Route::post('kategori_lembur/', 'kategori_lemburController@store')->name('kategori_lembur.store');
            Route::get('kategori_lembur/{kategori_lembur}/edit', 'kategori_lemburController@edit')->name('kategori_lembur.edit');
            Route::patch('kategori_lembur/{kategori_lembur}/update', 'kategori_lemburController@update')->name('kategori_lembur.update');
            Route::get('kategori_lembur/{id}', 'Kategori_lemburController@destroy')->name('kategori_lembur.destroy');
        });

        Route::get('lembur_pegawai', 'lembur_pegawaiController@show')->name('lembur_pegawai.show');
        Route::middleware('role:admin|accounting')->group(function () {
            Route::get('lembur_pegawai/create', 'lembur_pegawaiController@create')->name('lembur_pegawai.create');
            Route::post('lembur_pegawai/', 'lembur_pegawaiController@store')->name('lembur_pegawai.store');
            Route::get('lembur_pegawai/{lembur_pegawai}/edit', 'lembur_pegawaiController@edit')->name('lembur_pegawai.edit');
            Route::patch('lembur_pegawai/{lembur_pegawai}/update', 'lembur_pegawaiController@update')->name('lembur_pegawai.update');
            Route::get('lembur_pegawai/{id}', 'lembur_pegawaiController@destroy')->name('lembur_pegawai.destroy');
            Route::get('lembur_pegawai/export/excel/filter={filter}', 'lembur_pegawaiController@excel')->name('lembur_pegawai.export.excel');
        });
    });

        Route::namespace('Master')->prefix('master')->name('master.')->group(function () {
            Route::get('position', 'PositionController@index')->name('position.index');
                Route::get('position/create', 'PositionController@create')->name('position.create');
                Route::post('position', 'PositionController@store')->name('position.store');
                Route::get('position/{position}/edit', 'PositionController@edit')->name('position.edit');
                Route::patch('position/{position}/update', 'PositionController@update')->name('position.update');
                Route::get('position/{id}', 'PositionController@destroy')->name('position.destroy');

            Route::get('departement', 'DepartementController@index')->name('departement.index');
            Route::get('staff', 'StaffController@index')->name('staff.index');
                Route::get('departement/create', 'DepartementController@create')->name('departement.create');
                Route::post('departement', 'DepartementController@store')->name('departement.store');
                Route::get('departement/{departement}/edit', 'DepartementController@edit')->name('departement.edit');
                Route::patch('departement/{departement}/update', 'DepartementController@update')->name('departement.update');
                Route::get('departement/{id}', 'DepartementController@destroy')->name('departement.destroy');

                Route::get('staff/create', 'StaffController@create')->name('staff.create');
                Route::post('staff', 'StaffController@store')->name('staff.store');
                Route::get('staff/{staff}/edit', 'StaffController@edit')->name('staff.edit');
                Route::patch('staff/{staff}/update', 'StaffController@update')->name('staff.update');
                Route::get('staff/{id}', 'StaffController@destroy')->name('staff.destroy');
            });


        Route::get('salary', 'SalaryController@index')->name('salary.index');
        Route::get('salary/detail/id={id}', 'SalaryController@show')->name('salary.show');
        Route::get('overtime', 'OvertimeController@index')->name('overtime.index');

            Route::get('salary/create', 'SalaryController@create')->name('salary.create');
            Route::post('salary/detail/create', 'SalaryController@store')->name('salary.store');
            Route::post('salary/detail/create/store', 'SalaryController@storeDetail')->name('salary.detail.store');
            Route::get('salary/detail/{salary}/edit', 'SalaryController@edit')->name('salary.detail.edit');

            Route::patch('salary/{salary}/update', 'SalaryController@update')->name('salary.update');
            Route::get('staff/get_salary', 'SalaryController@getSalary');
            Route::get('salary/{id}', 'SalaryController@destroyDetail')->name('salary.destroyDetail');
            Route::get('salary/export/excel/id={id}/filter={filter}', 'SalaryController@excel')->name('salary.export.excel');


    Route::get('kategori_lembur', 'kategori_lemburController@index')->name('kategori_lembur.index');
    Route::get('kategori_lembur/create', 'kategori_lemburController@create')->name('kategori_lembur.create');
    Route::post('kategori_lembur/', 'kategori_lemburController@store')->name('kategori_lembur.store');
    Route::get('kategori_lembur/{kategori_lembur}/edit', 'kategori_lemburController@edit')->name('kategori_lembur.edit');
    Route::patch('kategori_lembur/{kategori_lembur}/update', 'kategori_lemburController@update')->name('kategori_lembur.update');
    Route::get('kategori_lembur/{id}', 'Kategori_lemburController@destroy')->name('kategori_lembur.destroy');

    Route::get('lembur_pegawai', 'lembur_pegawaiController@show')->name('lembur_pegawai.show');
    Route::get('lembur_pegawai', 'lembur_pegawaiController@index')->name('lembur_pegawai.index');
        Route::get('lembur_pegawai/create', 'lembur_pegawaiController@create')->name('lembur_pegawai.create');
        Route::post('lembur_pegawai/', 'lembur_pegawaiController@store')->name('lembur_pegawai.store');
        Route::get('lembur_pegawai/{lembur_pegawai}/edit', 'lembur_pegawaiController@edit')->name('lembur_pegawai.edit');
        Route::patch('lembur_pegawai/{lembur_pegawai}/update', 'lembur_pegawaiController@update')->name('lembur_pegawai.update');
        Route::get('lembur_pegawai/{id}', 'lembur_pegawaiController@destroy')->name('lembur_pegawai.destroy');
        Route::get('lembur_pegawai/export/excel/filter={filter}', 'lembur_pegawaiController@excel')->name('lembur_pegawai.export.excel');

        Route::get('salary', 'SalaryController@index')->name('salary.index');
        Route::get('salary/detail/id={id}', 'SalaryController@show')->name('salary.show');
        Route::get('overtime', 'OvertimeController@index')->name('overtime.index');

            Route::get('salary/create', 'SalaryController@create')->name('salary.create');
            Route::post('salary/detail/create', 'SalaryController@store')->name('salary.store');
            Route::post('salary/detail/create/store', 'SalaryController@storeDetail')->name('salary.detail.store');
            Route::get('salary/detail/{salary}/edit', 'SalaryController@edit')->name('salary.detail.edit');

            Route::patch('salary/{salary}/update', 'SalaryController@update')->name('salary.update');
            Route::get('staff/get_salary', 'SalaryController@getSalary');
            Route::get('salary/{id}', 'SalaryController@destroyDetail')->name('salary.destroyDetail');
            Route::get('salary/export/excel/id={id}/filter={filter}', 'SalaryController@excel')->name('salary.export.excel');
});
