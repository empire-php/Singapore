<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::post('/pre-login', 'Auth\AuthController@preLoginCheck');
    Route::get('/pre-login', 'Auth\AuthController@preLogin');
    Route::post('/login', 'Auth\AuthController@postLogin');

    Route::get('/',                                         'HomeController@index');
    // SETTINGS
    Route::post('/settings/update-secret-key',              'SettingsController@updateSecretKey');
    Route::post('/settings/update-company/{id}',            'SettingsController@updateCompany');
    Route::post('/settings/update-department/{id}',         'SettingsController@updateDepartment');
    Route::post('/settings/update-shifting/{did}/{uid}',    'SettingsController@updateShifting');
    Route::post('/settings/update-fa/{did}/{uid}',          'SettingsController@updateFASetting');
    Route::post('/settings/update-gemstone/{did}/{uid}',    'SettingsController@updateGemstoneSetting');
    Route::post('/settings/update-columbarium/{did}/{uid}', 'SettingsController@updateColumbariumSetting');
    Route::post('/settings/update-inventory/{did}/{uid}',   'SettingsController@updateInventorySetting');
    Route::post('/settings/create-department',              'SettingsController@createDepartment');
    Route::get('/settings',                                 'SettingsController@index');
    Route::get('/settings/search_inventory_category',       'SettingsController@searchInventoryCategory');
    Route::get('/settings/search_inventory_item',           'SettingsController@searchInventoryItem');
    Route::get('/settings/get_items_settings',              'SettingsController@getItemsSetttings');
    Route::post('/settings/save_items_settings',            'SettingsController@saveItemsSetttings');
    Route::post('/settings/delete_items_settings',          'SettingsController@deleteItemsSetttings');
    Route::get('/settings/search_fa_sales_package',         'SettingsController@searchFASalesPackage');
    Route::get('/settings/search_group_name',               'SettingsController@searchGroupName');
    Route::get('/settings/save_discount',                   'SettingsController@saveDiscount');
    Route::get('/settings/delete_discount',                 'SettingsController@deleteDiscount');
    Route::get('/settings/edit_fa_package',                 'SettingsController@editPackage');
    Route::post('/settings/save_fa_package',                'SettingsController@savePackage');
    Route::get('/settings/delete_fa_package',               'SettingsController@deletePackage');
    Route::get('/settings/delete_fa_package_item',          'SettingsController@deletePackageItem');
    Route::get('/settings/list_fa_packages',                'SettingsController@getPackagesList');
    
    
    Route::get('/users',                                    'UsersController@index');
    Route::post('/users/create',                            'UsersController@create');
    Route::post('/users/update/{id}',                       'UsersController@update');
    Route::post('/users/{id}',                              'UsersController@updateByFiled');
    Route::get('/users/edit/{id}',                          'UsersController@edit');
    
    // NOTIFICATIONS
    Route::get('/notifications',                            'NotificationsController@index');
    Route::get('/notifications/popup',                      'NotificationsController@popup');
    Route::get('/notifications/show_pdf/{id}',              'NotificationsController@showPdf');
    Route::get('/notifications/delete/{id}',                'NotificationsController@delete');
    
    // SHIFTING
    Route::get('/shifting',                             'ShiftingController@index');
    Route::post('/shifting/create',                     'ShiftingController@create');
    Route::post('/shifting/update/{id}',                'ShiftingController@update');
    Route::get('/shifting/search_parlour',              'ShiftingController@searchParlour');
    Route::get('/shifting/{id}',                        'ShiftingController@show');
    Route::get('/shifting/view/{id}',                   'ShiftingController@view');
    Route::get('/view_ss',                              'ShiftingController@listing');
    
    // FUNERAL ARRANGEMENT
    Route::get('/fa',                                   'FuneralArrangementController@createFA');
    Route::get('/fa/step2',                             'FuneralArrangementController@stepTwo');
    Route::get('/fa/step3',                             'FuneralArrangementController@stepThree');
    Route::get('/fa/step4',                             'FuneralArrangementController@stepFour');
    Route::get('/view_fa',                              'FuneralArrangementController@index');
    Route::get('/fa/view/{id}',                         'FuneralArrangementController@view');
    Route::post('/fa/delete_current',                   'FuneralArrangementController@deleteDraft');
    Route::post('/fa/autosave_checklist',               'FuneralArrangementController@autoSaveChecklist');
    Route::post('/fa/saveForm',                         'FuneralArrangementController@saveData');
    Route::get('/fa/genpdf/{name}/{fa_id}',             'FuneralArrangementController@generatePDF');
    Route::get('/fa/search_deceased',                   'FuneralArrangementController@searchDeceased');
    Route::get('/fa/search_dialect',                    'FuneralArrangementController@searchDialect');
    Route::get('/fa/download/{fa_id}',                  'FuneralArrangementController@dowloadFaFile');
    Route::get('/fa/get_stock_info',                    'FuneralArrangementController@getStockInfo');
    Route::get('/FArepatriation',                       'FuneralArrangementController@FArepatriation');
    Route::get('/FArepatriation/step2',                 'FuneralArrangementController@FArepatriationStepTwo');
    Route::get('/FArepatriation/step3',                 'FuneralArrangementController@FArepatriationStepThree');
    Route::post('/FArepatriation/save',                 'FuneralArrangementController@saveFARepatriation');
    Route::post('/FArepatriation/autosave_checklist',   'FuneralArrangementController@autoSaveFARepatriationChecklist');
    Route::post('/FArepatriation/delete_current',       'FuneralArrangementController@deleteCurrentFARepatriation');
    
    
    // EMBALMING
    Route::get('/embalming',                            'EmbalmingController@index');
    Route::get('/embalming/search_deceased',            'EmbalmingController@searchDeceased');
    Route::get('/embalming/timelog/{section}',          'EmbalmingController@getTimelog');
    
    // INVERTORY
    Route::get('/inventory',                            'InventoryController@index');
    Route::get('/inventory/list',                       'InventoryController@getListing');
    Route::post('/inventory/save',                      'InventoryController@saveData');
    Route::get('/inventory/prodcateg',                  'InventoryController@getCategories');
    Route::get('/inventory/check_low_stock',            'InventoryController@checkLowStock');
    Route::get('/inventory/delete/{id}',                'InventoryController@deleteProduct');
    Route::get('/inventory/get/{id}',                   'InventoryController@getProduct');
    
    //GERMSTONES
    Route::get('/gemstone',                             'GemstoneController@index');
    Route::get('/gemstone/view/{id}',                   'GemstoneController@view');
    Route::get('/gemstone/search_fa',                   'GemstoneController@getFA');
    Route::get('/gemstone/search_deceased_name',        'GemstoneController@searchDeceased');
    Route::post('/gemstone/save',                       'GemstoneController@saveForm');
    Route::post('/gemstone/delete_current',             'GemstoneController@deleteCurrentDraft');
    Route::get('/gemstone/pdf/{id}',                    'GemstoneController@generatePdf');
    Route::get('/view_gs',                              'GemstoneController@listing');
    
    
    //Columbarium
    Route::get('/columbarium',                          'ColumbariumController@index');
    Route::get('/columbarium/view/{id}',                'ColumbariumController@view');
    Route::get('/columbarium/search_fa',                'ColumbariumController@getFA');
    Route::get('/columbarium/search_deceased_name',     'ColumbariumController@searchDeceased');
    Route::post('/columbarium/save',                    'ColumbariumController@saveForm');
    Route::post('/columbarium/delete_current',          'ColumbariumController@deleteCurrentDraft');
    Route::get('/columbarium/pdf/{id}',                 'ColumbariumController@generatePdf');
    Route::get('/view_co',                              'ColumbariumController@listing');
    
    // ASH COLLECTION
    Route::get('/ashcollection',                        'AshCollectionController@index');
    Route::get('/ashcollection/view/{id}',              'AshCollectionController@view');
    Route::get('/ashcollection/search_fa',              'AshCollectionController@searchFA');
    Route::get('/ashcollection/search_deceased_name',   'AshCollectionController@searchDeceasedName');
    Route::get('/ashcollection/search_nric',            'AshCollectionController@searchNRIC');
    Route::post('/ashcollection/save',                  'AshCollectionController@saveForm');
    Route::post('/ashcollection/delete_current',        'AshCollectionController@deleteCurrentDraft');
    Route::get('/ashcollection/pdf/{id}',               'AshCollectionController@generatePdf');
    Route::get('/view_ac',                              'AshCollectionController@listing');
    
    // HEARSE
    Route::get('/hearse',                               'HearseController@index');
    Route::get('/hearse/hearseallocation',              'HearseController@hearseAllocation');
    Route::post('/hearse/save',                         'HearseController@saveForm');
    Route::get('/hearse/view/{id}',                     'HearseController@view');
    Route::get('/hearse/pview/{id}',                     'HearseController@pview');
    Route::get('/hearse/listing',                       'HearseController@listing');
    Route::get('/hearse/dblisting',                       'HearseController@dblisting');
    Route::get('/hearse/hearseallclisting',             'HearseController@hearseallclisting');
    Route::get('/hearse/booked_hours',                  'HearseController@bookedHours');
    Route::get('/hearse/search_fa',                     'HearseController@getFA');
    Route::get('/hearse/search_deceased_name',          'HearseController@searchDeceased');
    Route::get('/hearse/search_nric',                   'HearseController@searchNRIC');
    Route::get('/hearse/popup',                         'HearseController@popup');
    Route::get('/hearse/end_date',                      'HearseController@getEndDate');
    Route::post('/hearse/updatemanpower/{id}',          'HearseController@updateHearseOrderManpower');
    
    // PARLOUR
    Route::get('/parlour',                               'ParlourController@index');
    Route::post('/parlour/save',                         'ParlourController@saveForm');
    Route::get('/parlour/view/{id}',                     'ParlourController@view');
    Route::get('/parlour/pview/{id}',                     'ParlourController@pview');
    Route::get('/parlour/listing',                       'ParlourController@listing');
    Route::get('/parlour/dblisting',                     'ParlourController@dblisting');
    Route::get('/parlour/booked_hours',                  'ParlourController@bookedHours');
    Route::get('/parlour/search_fa',                     'ParlourController@getFA');
    Route::get('/parlour/search_deceased_name',          'ParlourController@searchDeceased');
    Route::get('/parlour/search_nric',                   'ParlourController@searchNRIC');
    Route::get('/parlour/popup',                         'ParlourController@popup');
    Route::get('/parlour/end_date',                      'ParlourController@getEndDate');
    
    // SCC Care Orders
    Route::get('/scc/buddhist',                          'CareOrderController@indexBuddhist');
    Route::get('/scc/pdf/{id}',                          'CareOrderController@generatePdf');
    Route::get('/scc/buddhist/view/{id}',                'CareOrderController@view');
    Route::post('/scc/save',                             'CareOrderController@save');
    Route::get('/scc/search_fa',                         'CareOrderController@searchFA');
    Route::get('/scc/search_deceased_name',              'CareOrderController@searchDeceasedName');
    Route::get('/scc/search_nric',                       'CareOrderController@searchNRIC');
    
    Route::get('/scc/christian',                         'CareOrderController@indexChristian');
    Route::get('/scc/christian/view/{id}',               'CareOrderController@view');
    Route::get('/scc/tidbits',                           'CareOrderController@indexTidbits');
    Route::get('/scc/tidbits/view/{id}',                 'CareOrderController@view');
    Route::get('/scc/chanting',                          'CareOrderController@indexChanting');
    Route::get('/scc/chanting/view/{id}',                'CareOrderController@view');
    Route::get('/scc/tentage',                           'CareOrderController@indexTentage');
    Route::get('/scc/tentage/view/{id}',                 'CareOrderController@view');
    Route::post('/scc/delete_current',                   'CareOrderController@deleteCurrentDraft');
    
    // HEARSE
    Route::get('/manpowerallocation',                    'ManpowerController@index');
    Route::post('/manpowerallocation/editingstatus/{id}', 'ManpowerController@updateEditingStatus');
    Route::post('/manpowerallocation/updatemanpower/{id}', 'ManpowerController@updateAllManpower');
    Route::post('/manpowerallocation/updatemanpowertext/{id}', 'ManpowerController@updateAllManpowerText');
    Route::post('/manpowerallocation/updatemanpowerparlour/{id}', 'ManpowerController@updateParlourOrderManpower');
    Route::post('/manpowerallocation/updatemanpowerparlourcleaning/{id}', 'ManpowerController@updateParlourOrderManpowerCleaning');
    /*
    Route::post('/scc/{$type}/delete/{id}',             'CareOrderController@delete');
    Route::get('/scc/{$type}/listing',                  'CareOrderController@listing');*/
});

if (false) {

    Route::group(['middleware' => ['auth']], function () {
        /**
         * Show Task Dashboard
         */
        Route::get('/', function () {
            return view('tasks', [
                'tasks' => Task::orderBy('created_at', 'asc')->get(),
            ]);
        });

        /**
         * Add New Task
         */
        Route::post('/task', function (Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $task = new Task;
            $task->name = $request->name;
            $task->save();

            return redirect('/');
        });

        /**
         * Delete Task
         */
        Route::delete('/task/{id}', function ($id) {
            Task::findOrFail($id)->delete();

            return redirect('/');
        });
    });
}