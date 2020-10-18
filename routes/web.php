<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/admin/expenses');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Expensecategories
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Incomecategories
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expenses
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Incomes
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expensereports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    Route::resource('areas', 'AreaController');
    Route::resource('cost-center', 'Admin\CostCenterController');
    Route::resource('suppliers', 'Admin\SupplierController');
    Route::resource('client', 'Admin\ClientController');
    Route::resource('status', 'Admin\StatusController');


    Route::get('areas/create', 'AreaController@create')->name('areas.create');
});

Route::get('areas/', 'Admin\AreaController@index')->name('areas.index');
Route::post('areas/store', 'Admin\AreaController@store')->name('areas.store');
Route::get('areas/create', 'Admin\AreaController@create')->name('areas.create');
Route::get('areas/edit/{id}', 'Admin\AreaController@edit')->name('areas.edit');
Route::get('areas/show/{id}', 'Admin\AreaController@show')->name('areas.show');
Route::delete('areas/delete/{id}', 'Admin\AreaController@destroy')->name('areas.destroy');
Route::patch('areas/update/{id}', 'Admin\AreaController@update')->name('areas.update');

Route::get('cost-center/', 'Admin\CostCenterController@index')->name('cost-centers.index');
Route::post('cost-center/store', 'Admin\CostCenterController@store')->name('cost-centers.store');
Route::get('cost-center/create', 'Admin\CostCenterController@create')->name('cost-centers.create');
Route::get('cost-center/edit/{id}', 'Admin\CostCenterController@edit')->name('cost-centers.edit');
Route::get('cost-center/show/{id}', 'Admin\CostCenterController@show')->name('cost-centers.show');
Route::delete('cost-center/delete/{id}', 'Admin\CostCenterController@destroy')->name('cost-centers.destroy');
Route::patch('cost-center/update/{id}', 'Admin\CostCenterController@update')->name('cost-centers.update');


Route::get('suppliers/', 'Admin\SupplierController@index')->name('suppliers.index');
Route::post('suppliers/store', 'Admin\SupplierController@store')->name('suppliers.store');
Route::get('suppliers/create', 'Admin\SupplierController@create')->name('suppliers.create');
Route::get('suppliers/edit/{id}', 'Admin\SupplierController@edit')->name('suppliers.edit');
Route::get('suppliers/show/{id}', 'Admin\SupplierController@show')->name('suppliers.show');
Route::delete('suppliers/delete/{id}', 'Admin\SupplierController@destroy')->name('suppliers.destroy');
Route::patch('suppliers/update/{id}', 'Admin\SupplierController@update')->name('suppliers.update');

Route::get('legal-centers/', 'Admin\LegalCenterController@index')->name('legal-centers.index');
Route::post('legal-centers/store', 'Admin\LegalCenterController@store')->name('legal-centers.store');
Route::get('legal-centers/create', 'Admin\legalCenterController@create')->name('legal-centers.create');
Route::get('legal-centers/edit/{id}', 'Admin\LegalCenterController@edit')->name('legal-centers.edit');
Route::get('legal-centers/show/{id}', 'Admin\LegalCenterController@show')->name('legal-centers.show');
Route::delete('legal-centers/delete/{id}', 'Admin\LegalCenterController@destroy')->name('legal-centers.destroy');
Route::patch('legal-centers/update/{id}', 'Admin\LegalCenterController@update')->name('legal-centers.update');



Route::get('legal/create', 'Admin\LegalCenterController@legal')->name('legal.index');
Route::get('legal/new', 'Admin\LegalCenterController@new')->name('legal.new');
Route::post('legal/save', 'Admin\LegalCenterController@saveLegalCost')->name('legal.save');
Route::get('legal/delete/{id}', 'Admin\LegalCenterController@legalDelete')->name('legal.delete');



Route::get('clients/get', 'Admin\ClientController@loadClients')->name('get.clients');
Route::get('client/', 'Admin\ClientController@index')->name('client.index');
Route::post('client/store', 'Admin\ClientController@store')->name('client.store');
Route::get('client/create', 'Admin\ClientController@create')->name('client.create');
Route::get('client/edit/{id}', 'Admin\ClientController@edit')->name('client.edit');
Route::get('client/show/{id}', 'Admin\ClientController@show')->name('client.show');
Route::delete('client/delete/{id}', 'Admin\ClientController@destroy')->name('client.destroy');
Route::patch('client/update/{id}', 'Admin\ClientController@update')->name('client.update');

Route::get('status/', 'Admin\StatusController@index')->name('status.index');
Route::post('status/store', 'Admin\StatusController@store')->name('status.store');
Route::get('status/create', 'Admin\StatusController@create')->name('status.create');
Route::get('status/edit/{id}', 'Admin\StatusController@edit')->name('status.edit');
Route::get('status/show/{id}', 'Admin\StatusController@show')->name('status.show');
Route::delete('status/delete/{id}', 'Admin\StatusController@destroy')->name('status.destroy');
Route::patch('status/update/{id}', 'Admin\StatusController@update')->name('status.update');


Route::get('sendText', 'Admin\ClientController@sendSampleText')->name('text.send');
Route::post('meter_reading', 'Admin\MeterController@meter_reading');
Route::get('sendNotification/{id}', 'Admin\MeterController@sendNotification');
Route::post('updateReadings', 'Admin\MeterController@updateReadings');

Route::get('meter/', 'Admin\MeterController@index')->name('meter.index');
Route::get('meter_reading_/{id}/{aid}', 'Admin\MeterController@register')->name('meter.reading.m');
Route::post('save_reading/{cid}/{id}/{aid}', 'Admin\MeterController@save_reading')->name('save.meter.reading');
Route::post('meter/store', 'Admin\MeterController@store')->name('meter.store');
Route::get('meter/create', 'Admin\MeterController@create')->name('meter.create');
Route::get('meter/edit/{id}', 'Admin\MeterController@edit')->name('meter.edit');
Route::get('meter/show/{id}', 'Admin\MeterController@show')->name('meter.show');
Route::delete('meter/delete/{id}', 'Admin\MeterController@destroy')->name('meter.destroy');
Route::patch('meter/update/{id}', 'Admin\MeterController@update')->name('meter.update');


Route::get('settings-nbrd/', 'Admin\SettingsNbrdController@index')->name('settings_nbrd.index');
Route::post('settings-nbrd/store', 'Admin\SettingsNbrdController@store')->name('settings_nbrd.store');
Route::get('settings-nbrd/create', 'Admin\SettingsNbrdController@create')->name('settings_nbrd.create');
Route::get('settings-nbrd/edit/{id}', 'Admin\SettingsNbrdController@edit')->name('settings_nbrd.edit');
Route::get('settings-nbrd/show/{id}', 'Admin\SettingsNbrdController@show')->name('settings_nbrd.show');
Route::delete('settings-nbrd/delete/{id}', 'Admin\SettingsNbrdController@destroy')->name('settings_nbrd.destroy');
Route::patch('settings-nbrd/update/{id}', 'Admin\SettingsNbrdController@update')->name('settings_nbrd.update');

Route::get('settings-dpm/', 'Admin\SettingsDpmController@index')->name('settings_dpm.index');
Route::post('settings-dpm/store', 'Admin\SettingsDpmController@store')->name('settings_dpm.store');
Route::get('settings-dpm/create', 'Admin\SettingsDpmController@create')->name('settings_dpm.create');
Route::get('settings-dpm/edit/{id}', 'Admin\SettingsDpmController@edit')->name('settings_dpm.edit');
Route::get('settings-dpm/show/{id}', 'Admin\SettingsDpmController@show')->name('settings_dpm.show');
Route::delete('settings-dpm/delete/{id}', 'Admin\SettingsDpmController@destroy')->name('settings_dpm.destroy');
Route::patch('settings-dpm/update/{id}', 'Admin\SettingsDpmController@update')->name('settings_dpm.update');

Route::get('billing/', 'Admin\TransactionController@index')->name('billing.index');
Route::get('billing/{id}/{aid}', 'Admin\TransactionController@register')->name('bill.reading');
Route::post('billing/{cid}/{id}/{aid}', 'Admin\TransactionController@save_reading')->name('save.bill.reading');
Route::post('billing/store', 'Admin\TransactionController@store')->name('bill.store');
Route::get('billing/create', 'Admin\TransactionController@create')->name('bill.create');
Route::get('billing/edit/{id}', 'Admin\TransactionController@edit')->name('bill.edit');
Route::get('billing/show/{id}', 'Admin\TransactionController@show')->name('bill.show');
Route::delete('billing/delete/{id}', 'Admin\TransactionController@destroy')->name('bill.destroy');
Route::patch('billing/update/{id}', 'Admin\TransactionController@update')->name('bill.update');


Route::get('payment/', 'Admin\PaymentController@index')->name('payment.index');
Route::get('payment/{id}/{aid}', 'Admin\PaymentController@register')->name('payment.reading');
Route::post('payment/{cid}/{id}/{aid}', 'Admin\PaymentController@save_reading')->name('save.payment.reading');
Route::post('payment/store', 'Admin\PaymentController@store')->name('payment.store');
Route::get('payment/create', 'Admin\PaymentController@create')->name('payment.create');
Route::get('payment/edit/{id}', 'Admin\PaymentController@edit')->name('payment.edit');
Route::get('payment/show/{id}', 'Admin\PaymentController@show')->name('payment.show');
Route::delete('payment/delete/{id}', 'Admin\PaymentController@destroy')->name('payment.destroy');
Route::patch('payment/update/{id}', 'Admin\PaymentController@update')->name('payment.update');


Route::get('disconnected/bill', 'Admin\TransactionController@disconnected')->name('billing.disconnected');





Route::get('payment/adjustment', 'Admin\PaymentController@adjust')->name('payment.adjust');
Route::post('payment/store/adjustment', 'Admin\PaymentController@saveAdjustments')->name('payment.save.adjustment');


/* Route::get('payment/', 'Admin\PaymentController@index')->name('payment.index');
  Route::get('payment/{id}/{aid}', 'Admin\PaymentController@register')->name('payment.reading');
  Route::post('payment/{cid}/{id}/{aid}', 'Admin\PaymentController@save_reading')->name('save.payment.reading');
  Route::post('payment/store', 'Admin\PaymentController@store')->name('payment.store');
  Route::get('payment/create', 'Admin\PaymentController@create')->name('payment.create');
  Route::get('payment/edit/{id}', 'Admin\PaymentController@edit')->name('payment.edit');
  Route::get('payment/show/{id}', 'Admin\PaymentController@show')->name('payment.show');
  Route::delete('payment/delete/{id}', 'Admin\PaymentController@destroy')->name('payment.destroy');
  Route::patch('payment/update/{id}', 'Admin\PaymentController@update')->name('payment.update'); */


Route::get('bank/', 'Admin\BankController@index')->name('bank.index');
//Route::get('bank/{id}/{aid}', 'Admin\BankController@register')->name('bank.reading');
Route::post('bank/{cid}/{id}/{aid}', 'Admin\BankController@save_reading')->name('save.bank.reading');
Route::post('bank/store', 'Admin\BankController@store')->name('bank.store');
Route::get('bank/create', 'Admin\BankController@create')->name('bank.create');
Route::get('bank/edit/{id}', 'Admin\BankController@edit')->name('bank.edit');
Route::get('bank/show/{id}', 'Admin\BankController@show')->name('bank.show');
Route::delete('bank/delete/{id}', 'Admin\BankController@destroy')->name('bank.destroy');
Route::patch('bank/update/{id}', 'Admin\BankController@update')->name('bank.update');



Route::get('branch/', 'Admin\BranchController@index')->name('branch.index');
Route::get('branch/{bank}/{name}', 'Admin\BranchController@index')->name('bank.branch');
//Route::post('branch/{cid}/{id}/{aid}', 'Admin\BranchController@save_reading')->name('save.branch.reading');
Route::post('branch/store/{bank}/{name}', 'Admin\BranchController@store')->name('branch.store');
Route::get('branch/create/{bank}/{name}', 'Admin\BranchController@create')->name('branch.create');
Route::get('branch/edit/{id}/{bank}/{name}', 'Admin\BranchController@edit')->name('branch.edit');
Route::get('branch/show/{id}', 'Admin\BranchController@show')->name('branch.show');
Route::delete('branch/delete/{id}/{bank}/{name}', 'Admin\BranchController@destroy')->name('branch.destroy');
Route::patch('branch/update/{id}/{bank}/{name}', 'Admin\BranchController@update')->name('branch.update');


Route::get('mops/', 'Admin\MopController@index')->name('mops.index');
Route::post('mops/store', 'Admin\mopController@store')->name('mops.store');
Route::get('mops/create', 'Admin\mopController@create')->name('mops.create');
Route::get('mops/edit/{id}', 'Admin\MopController@edit')->name('mops.edit');
Route::get('mops/show/{id}', 'Admin\MopController@show')->name('mops.show');
Route::delete('mops/delete/{id}', 'Admin\mopController@destroy')->name('mops.destroy');
Route::patch('mops/update/{id}', 'Admin\MopController@update')->name('mops.update');


Route::get('invoice/', 'Admin\PaymentController@invoice')->name('invoicing.index');
Route::get('invoice/create', 'Admin\PaymentController@create_invoice')->name('invoicing.create');
Route::post('invoice/store', 'Admin\PaymentController@saveInvoice')->name('invoicing.store');
Route::get('invoice/show/{cid}/{ref}', 'Admin\PaymentController@showInvoice')->name('invoicing.show');
Route::get('invoice/delete/{ref}', 'Admin\PaymentController@deleteInvoice')->name('invoicing.delete');
Route::get('invoice/edit/{cid}/{ref}', 'Admin\PaymentController@editInvoice')->name('invoicing.edit');
Route::post('invoice/storeedit/{cid}/{ref}', 'Admin\PaymentController@saveInvoiceEdit')->name('invoicing.store_edit');
Route::post('invoice/savepayment', 'Admin\PaymentController@saveInvoicePayment')->name('invoicing.pay');
Route::post('invoice/savepayment', 'Admin\PaymentController@saveInvoicePayment')->name('invoicing.pay');
Route::get('invoice/deletepay/{id}/{ref}', 'Admin\PaymentController@deleteInvoiceMicro')->name('invoicing.delete_pay');
Route::get('invoice/loaddetails/{ref}', 'Admin\PaymentController@loadPaymentDetails')->name('invoicing.details');


Route::get('clients/print/{ref}', 'Admin\ClientController@createPDF')->name('clients.print');



Route::get('receipt', 'Admin\TransactionController@receipt')->name('receipt.index');
Route::get('run-bill', 'Admin\MeterController@runBill')->name('run.bill');
Route::get('bank-branches/{bank}', 'Admin\PaymentController@loadBranches')->name('bank.branches');
Route::get('client-info/{pid}/{client_id}', 'Admin\PaymentController@loadClientInformation')->name('client.info');
Route::get('client-info-receipt/{pid}/{client_id}', 'Admin\ReceiptController@index')->name('client.receipt');

Route::get('receipt', 'Admin\TransactionController@receipt')->name('receipt.index');

Route::get('find_id/{id}', 'Admin\MeterController@getFid')->name('find.id');

Route::get('reading_sheet/{area_id}', 'Admin\MeterController@load_sheet')->name('reading.sheet');
Route::get('download_sheet/{area_id}', 'Admin\MeterController@download_sheet')->name('download.sheet');


Route::get('statement/{start}/{end}', 'Admin\TransactionController@statement')->name('statement.index');
Route::post('get-statement', 'Admin\TransactionController@get')->name('statement.get');
Route::get('statement/print', 'Admin\TransactionController@createPDF');

Route::get('ut', 'UsersController@index');

Route::post('disconnect_client', 'Admin\MeterController@disconnect')->name('client.disconnect');
Route::post('reconnect_client', 'Admin\MeterController@reconnect')->name('client.reconnect');

Route::get('avatar/{id}', 'Admin\ClientController@avatar')->name('client.avatar');
Route::get('receipt/{id}', 'Admin\ReceiptController@index')->name('receipt');

Route::get('receipt/create/new', 'Admin\ReceiptController@create')->name('receipt-create');

Route::get('client-last-info/{id}', 'Admin\MeterController@loadlast')->name('client.latest');

Route::get('notification/{id}/{date}', 'Admin\MeterController@notification_center')->name('notification.index');

Route::get('areas/report/{period}', 'Admin\AreaController@area_report')->name('area.report');

Route::get('point', 'Admin\AreaController@generateReferral')->name('point');

Route::get('/logout-user', function() {
    Auth::logout();
    return Redirect::to('login');
});



Route::group(['prefix' => 'api/v1'], function () {
    Route::get('client/{area}', 'Admin\MeterController@loadClient');
});



