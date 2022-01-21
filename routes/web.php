<?php

use App\Mail\UserRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

Route::middleware(['auth'])->group(function () {
    //region Rutas Panel Administrativo
    Route::middleware(['user.role'])->prefix('admin')->group(function () {

        Route::middleware(['isAdminOrSupervisor'])->group(function () {
            Route::get('user/profile', 'Admin\ProfileController@index')
                ->name('admin.users.profile');
        });

        Route::middleware(['redirectIsNotActive'])->group(function () {
            Route::namespace('Admin')->group(function () {
                Route::get('dashboard', 'DashboardController@index')
                    ->name('admin.dashboard');

                Route::middleware(['admin'])->group(function () {
                    Route::get('users/roles/{role_id}', 'UserController@index')
                        ->name('admin.users.index');

                    Route::get('users/create', 'UserController@create')
                        ->name('admin.users.create');

                    Route::get('users/{user_id}', 'UserController@edit')
                        ->name('admin.users.edit');
                });

                Route::middleware(['isAdminOrSupervisor'])->group(function () {

                    Route::get('projects', 'ProjectController@index')
                        ->name('admin.projects.index');

                    Route::get('projects/create', 'ProjectController@create')
                        ->name('admin.projects.create');

                    Route::get('projects/{project_id}/edit', 'ProjectController@edit')
                        ->name('admin.projects.edit');

                    Route::get('projects/{project_id}/reports', 'ReportController@index')
                        ->name('admin.reports.index');

                    Route::get('projects/{project_id}/analysis', 'AnalysisResultsController@index')
                        ->name('admin.projects.analysis.index');

                    /*Project Images*/
                    Route::get('projects/{project_id}/images', 'ProjectImagesController@index')
                        ->name('admin.projects.images.index');

                    /*Findings*/
                    Route::get('projects/{project_id}/findings', 'FindingsController@index')
                        ->name('admin.projects.findings.index');

                    /*Calibration Certificates*/
                    Route::get('projects/{project_id}/calibration-certificates', 'CalibrationCertificatesController@index')
                        ->name('admin.projects.calibration_certificates.index');

                    /*Avance de Obra*/
                    Route::get('project/{project_id}/progress-work', 'ProgressWorksController@index')
                        ->name('admin.projects.progress_works.index');

                    /*Zonas Verificadas Dimensionalmente*/
                    Route::get('projects/{project_id}/zones-checked', 'ZoneCheckedController@index')
                        ->name('admin.projects.zones_checked.index');
                });
            });
        });
    });

    Route::middleware(['user.role'])
        ->namespace('Admin')->group(function () {
            Route::prefix('api-v1')->group(function () {
                Route::prefix('admin')->group(function () {
                    Route::middleware(['admin'])->group(function () {
                        Route::get('users/roles/{role_id}/get-data', 'UserController@getUserData')
                            ->name('admin.users.get_data');

                        Route::post('users/roles/{role_id}', 'UserController@createOrUpdate')
                            ->name('admin.users.store');

                        Route::put('users/{user_id}/roles/{role_id}', 'UserController@createOrUpdate')
                            ->name('admin.users.update');
                    });

                    Route::middleware(['isAdminOrSupervisor'])->group(function () {
                        Route::get('/users/profile/{user_id}', 'ProfileController@show');
                        Route::put('/users/profile/{user_id}', 'ProfileController@update');
                        Route::post('/users/profile/{user_id}/update/avatar', 'ProfileController@updateAvatar');

                        /*-----------------------------------------------------------------------------------------*/

                        Route::get('projects/get-data', 'ProjectController@getProjectData')
                            ->name('admin.projects.get_data');

                        Route::post('supervisor/{user_id}/projects/{project_id?}', 'ProjectController@editOrCreate')
                            ->name('admin.projects.edit_or_create');

                        Route::post('projects/{project_id}/upload-licence', 'ConstructionLicenseController@store')
                            ->name('admin.projects.upload_license');

                        Route::post('projects/{project_id}/upload-quality-plan', 'QualityPlanController@store')
                            ->name('admin.projects.upload_quality_plan');

                        Route::post('projects/{project_id}/upload-esp-tec', 'EspTecController@store')
                            ->name('admin.projects.upload_esp_tec');

                        Route::post('projects/{project_id}/clients/{client_id}', 'ProjectController@addClientsToProject')
                            ->name('admin.projects.add_clients');

                        Route::get('/projects/{project_id}/clients', 'ProjectController@getClientsData')
                            ->name('admin.projects.get_clients');

                        Route::delete('/projects/{project_id}/clients/{client_id}', 'ProjectController@removeClientsFromProject')
                            ->name('admin.projects.delete_clientes_relations');
                        /*-----------------------------------------------------------------------------------------------*/

                        Route::post('projects/{project_id}/images', 'ProjectImagesController@create');
                        Route::get('projects/{project_id}/get-data-images', 'ProjectImagesController@getData')
                            ->name('admin.projects.images.getData');
                        Route::delete('projects-images/{project_image_id}', 'ProjectImagesController@delete');
                        Route::post('projects-images/{project_image_id}/restore', 'ProjectImagesController@restore');

                        /*--FINDINGS--*/
                        Route::post('projects/{project_id}/findings', 'FindingsController@store')
                            ->name('admin.projects.findings.store');
                        Route::get('projects/{project_id}/findings-data', 'FindingsController@getData')
                            ->name('admin.projects.findings.get_data');
                        Route::put('findings/{finding_id}', 'FindingsController@update')
                            ->name('admin.projects.findings.update');
                        Route::delete('findings/{finding_id}', 'FindingsController@delete')
                            ->name('admin.projects.findings.delete');

                        /*--CalibrationCertificates--*/
                        Route::post('projects/{project_id}/calibration-certificate', 'CalibrationCertificatesController@store')
                            ->name('admin.project.calibration_certificate.store');
                        Route::post('calibration-certificate/{calibration_certificate_id}', 'CalibrationCertificatesController@update')
                            ->name('admin.project.calibration_certificate.update');
                        Route::delete('calibration-certificate/{calibration_certificate_id}', 'CalibrationCertificatesController@delete')
                            ->name('admin.project.calibration_certificate.delete');

                        Route::get('projects/{project_id}/calibration-certificate/data', 'CalibrationCertificatesController@getData')
                            ->name('admin.project.calibration_certificate.get_data');

                        /*----------------------------------------------------------------------------------------------*/
                        Route::post('project/{project_id}/upload-report', 'ReportController@store')
                            ->name('admin.reports.store');

                        Route::get('projects/{project_id}/reports/get-data', 'ReportController@getReportsData')
                            ->name('admin.projects.reports');

                        Route::delete('reports/{report_id}', 'ReportController@delete')
                            ->name('admin.projects.reports.delete');

                        /*-----------------------------------------------------------------------------------------------------------------*/
                        Route::get('project/{project_id}/concrete-samples/', 'AnalysisResultsController@getConcreteSamplesData')
                            ->name('admin.projects.analysis.get_concrete_samples_data');

                        Route::post('project/{project_id}/concrete-samples', 'AnalysisResultsController@saveConcreteSample')
                            ->name('admin.project.analysis.save_concrete_samples');

                        Route::put('concrete-samples/{concrete_sample_id}', 'AnalysisResultsController@updateConcreteSample')
                            ->name('admin.project.analysis.update_concrete_samples');

                        Route::delete('concrete-samples/{concrete_sample_id}', 'AnalysisResultsController@deleteConcreteSample')
                            ->name('admin.project.analysis.delete_concrete_samples');

                        Route::get('project/{project_id}/concrete-sample-observations', 'AnalysisResultsController@getConcreteSampleObservations')
                            ->name('admin.project.analysus.get_concrete_sample_observations');

                        Route::post('project/{project_id}/concrete-sample-observations', 'AnalysisResultsController@saveConcreteSampleObservations')
                            ->name('admin.project.analysus.save_concrete_sample_observations');

                        Route::put('concrete-sample-observations/{concrete_sample_observation_id}', 'AnalysisResultsController@editConcreteSampleObservations')
                            ->name('admin.project.analysis.edit_concrete_sample_observations');

                        Route::delete('concrete-sample-observations/{concrete_sample_observation_id}', 'AnalysisResultsController@deleteConcreteSampleObservations')
                            ->name('admin.project.analysis.delete_concrete_sample_observations');

                        /*------------------------------------quantity-checks-test---------------------------------*/
                        Route::get('project/{project_id}/quantity-checks-test', 'QuantityCheckConcreteTestController@getData')
                            ->name('admin.project.quantity_check_test.get_data');

                        Route::post('project/{project_id}/quantity-check-test', 'QuantityCheckConcreteTestController@create')
                            ->name('admin.project.quantity_check_test.create');

                        Route::put('quantity-check-test/{quantity_concrete_test_id}', 'QuantityCheckConcreteTestController@update')
                            ->name('admin.project.quantity_check_test.update');

                        Route::delete('quantity-check-test/{quantity_concrete_test_id}', 'QuantityCheckConcreteTestController@delete')
                            ->name('admin.project.quantity_check_test.delete');

                        Route::get('project/{project_id}/quantity-concrete-sample-observations', 'QuantityCheckConcreteTestController@getQuantityConcreteSampleObservations')
                            ->name('admin.project.quantity.get_quantity_concrete_sample_observations');

                        Route::post('project/{project_id}/quantity-concrete-sample-observations', 'QuantityCheckConcreteTestController@saveQuantityConcreteSampleObservations')
                            ->name('admin.project.quantity.save_quantity_concrete_sample_observations');

                        Route::put('quantity-concrete-sample-observations/{quantity_concrete_observation_id}', 'QuantityCheckConcreteTestController@editQuantityConcreteSampleObservations')
                            ->name('admin.project.quantity.edit_quantity_concrete_sample_observations');

                        Route::delete('quantity-concrete-sample-observations/{quantity_concrete_observation_id}', 'QuantityCheckConcreteTestController@deleteQuantityConcreteSampleObservations')
                            ->name('admin.project.quantity.delete_quantity_concrete_sample_observations');

                        /*-----------------------------------steel-samples-----------------------------------------------*/
                        Route::get('project/{project_id}/steel-samples/', 'SteelSamplesController@index')
                            ->name('admin.project.steel_samples.index');
                        Route::post('project/{project_id}/steel-samples', 'SteelSamplesController@create')
                            ->name('admin.project.steel_samples.create');
                        Route::put('steel-samples/{steel_sample_id}', 'SteelSamplesController@update')
                            ->name('admin.project.steel_samples.update');
                        Route::delete('steel-samples/{steel_sample_id}', 'SteelSamplesController@delete')
                            ->name('admin.project.steel_samples.delete');

                        /*------------------------------------------steel-sample-observations------------------------------*/
                        Route::get('/project/{project_id}/steel-sample-observations', 'SteelSampleObservationsController@index')
                            ->name('admin.project.steel_sample_observations.index');

                        Route::post('/project/{project_id}/steel-sample-observations', 'SteelSampleObservationsController@create')
                            ->name('admin.project.steel_sample_observations.create');

                        Route::put('steel-sample-observations/{steel_sample_observation_id}', 'SteelSampleObservationsController@update')
                            ->name('admin.project.steel_sample_observations.update');

                        Route::delete('steel-sample-observations/{steel_sample_observation_id}', 'SteelSampleObservationsController@delete')
                            ->name('admin.project.steel_sample_observations.delete');

                        /*--------------------------------------quantity-check-samples-----------------------------------------*/
                        Route::get('project/{project_id}/quantity-check-samples', 'QuantityCheckSamplesController@index')
                            ->name('admin.project.quantity_check_sample.index');
                        Route::post('project/{project_id}/quantity-check-samples', 'QuantityCheckSamplesController@create')
                            ->name('admin.project.quantity_check_sample.create');
                        Route::put('quantity-check-samples/{quantity_check_samples_id}', 'QuantityCheckSamplesController@update')
                            ->name('admin.project.quantity_check_sample.update');
                        Route::delete('quantity-check-samples/{quantity_check_samples_id}', 'QuantityCheckSamplesController@delete')
                            ->name('admin.project.quantity_check_sample.delete');

                        /*--------------------------------------quantity-check-sample-observations-------------------------------------*/
                        Route::get('project/{project_id}/quantity-check-sample-observations', 'QuantityCheckSampleObservationsController@index')
                            ->name('admin.project.quantity_check_sample_observations.index');

                        Route::post('project/{project_id}/quantity-check-sample-observations', 'QuantityCheckSampleObservationsController@create')
                            ->name('admin.project.quantity_check_sample_observations.create');

                        Route::put('quantity-check-sample-observations/{quantity_check_sample_obs_id}',
                            'QuantityCheckSampleObservationsController@update')
                            ->name('admin.project.quantity_check_sample_observations.update');

                        Route::delete('quantity-check-sample-observations/{quantity_check_sample_obs_id}', 'QuantityCheckSampleObservationsController@delete')
                            ->name('admin.project.quantity_check_sample_observations.delete');

                        /*------------------------------------mesh-samples----------------------------------------------------*/
                        Route::get('project/{project_id}/mesh-samples/', 'MeshSampleController@index')
                            ->name('admin.project.mesh_samples.index');
                        Route::post('project/{project_id}/mesh-samples', 'MeshSampleController@create')
                            ->name('admin.project.mesh_samples.create');
                        Route::put('mesh-samples/{mesh_sample_id}', 'MeshSampleController@update')
                            ->name('admin.project.mesh_samples.update');
                        Route::delete('mesh-samples/{mesh_sample_id}', 'MeshSampleController@delete')
                            ->name('admin.project.mesh_samples.delete');

                        /*------------------------------------mesh-sample-observations-----------------------------------------*/
                        Route::get('/project/{project_id}/mesh-sample-observations', 'MeshSampleObservationsController@index')
                            ->name('admin.project.mesh_sample_observations.index');

                        Route::post('/project/{project_id}/mesh-sample-observations', 'MeshSampleObservationsController@create')
                            ->name('admin.project.mesh_sample_observations.create');

                        Route::put('mesh-sample-observations/{mesh_sample_observation_id}', 'MeshSampleObservationsController@update')
                            ->name('admin.project.mesh_sample_observations.update');

                        Route::delete('mesh-sample-observations/{mesh_sample_observation_id}', 'MeshSampleObservationsController@delete')
                            ->name('admin.project.mesh_sample_observations.delete');

                        /*-------------------------------------------Progress-Works-------------------------------------*/
                        Route::get('projects/{project_id}/progress-works-data', 'ProgressWorksController@getData')
                            ->name('admin.projects.progress_works.get_data');
                        Route::post('projects/{project_id}/progress-works', 'ProgressWorksController@store')
                            ->name('admin.projects.progress_works.store');
                        Route::put('projects/progress-works/{progress_work_id}', 'ProgressWorksController@update')
                            ->name('admin.projects.progress_works.update');
                        Route::delete('projects/progress-works/{progress_work_id}', 'ProgressWorksController@delete')
                            ->name('admin.projects.progress_works.delete');

                        /*-----------------------------------------settlement-control-----------------------------------*/
                        Route::get('/project/{project_id}/settlement-control', 'SettlementControlsController@index')
                            ->name('admin.project.settlement_control.index');
                        Route::post('/project/{project_id}/settlement-control', 'SettlementControlsController@create')
                            ->name('admin.project.settlement_control.create');
                        Route::put('settlement-control/{settlement_control_id}', 'SettlementControlsController@update')
                            ->name('admin.project.settlement_control.update');
                        Route::delete('settlement-control/{settlement_control_id}', 'SettlementControlsController@delete')
                            ->name('admin.project.settlement_control.delete');

                        /*--------------------------------------------------------------------------------------------------*/
                        Route::get('users/supervisor', 'UserController@getSupervisors')
                            ->name('admin.users.supervisors');

                        Route::get('users/clients', 'UserController@getClients')
                            ->name('admin.users.client');

                        /*-------------------------------------------state-observation-------------------------------------*/
                        Route::get('project/{project_id}/state-observations', 'StateObservationsController@index')
                            ->name('admin.project.state_observation.index');

                        Route::post('project/{project_id}/state-observations', 'StateObservationsController@store')
                            ->name('admin.project.state_observation.store');

                        Route::put('state-observations/{state_observation_id}', 'StateObservationsController@update')
                            ->name('admin.project.state_observation.update');

                        /*-------------------------------------------ZonesChecked------------------------------------------*/
                        Route::get('projects/{project_id}/zones-checked', 'ZoneCheckedController@getData')
                            ->name('admin.projects.zones_checked.getData');
                        Route::post('projects/{project_id}/zones-checked', 'ZoneCheckedController@store')
                            ->name('admin.projects.zones_checked.store');
                        Route::post('zones/{zone_id}/zones-upload-pdf', 'ZoneCheckedController@UploadPdf')
                            ->name('admin.projects.zones.zones_upload_pdf');
                        Route::delete('zones/{zone_id}/delete-pdf', 'ZoneCheckedController@deletePdf')
                            ->name('admin.projects.zones.delete_pdf');

                        Route::post('zones/{zone_id}/update-observations', 'ZoneCheckedController@updateObservations')
                            ->name('admin.projects.zones.update_observations');

                        Route::post('floors/{floor_id}', 'ZoneCheckedController@FloorStateUpdate')
                            ->name('admin.projects.zones.floor_state_update');
                    });

                    Route::get('roles', 'RoleController@getRoles')->name('admin.roles.all');
                });
            });
        });
    //endregion

    //region Rutas Clientes
    Route::middleware(['user.client'])->group(function () {

        Route::get('/', 'HomeController@index')->name('home');

        Route::get('/projects/{project_id?}', 'HomeController@index')->name('home.project');

        Route::get('profile', 'UserController@index')->name('profile');

        Route::prefix('api-v1')->group(function () {
            Route::get('profile/{user_id}', 'UserController@show')
                ->name('users.profile.show');

            Route::put('profile/{user_id}', 'UserController@update')
                ->name('users.profile.update');

            Route::post('profile/{user_id}/update/avatar', 'UserController@updateAvatar')
                ->name('user.profile.updateAvatar');

            Route::get('/get-calendar-data/{project_id}', 'HomeController@getReportData')
                ->name('users.project.report_data');

            /*-------------------------------------------------------------------------------------------------------------------------*/
            Route::get('concrete-samples/{project_id}', 'HomeController@getDataConcreteSamples')
                ->name('users.project.concrete_samples');

            Route::get('project/{project_id}/concrete-sample-observations', 'HomeController@getConcreteSampleObservations')
                ->name('users.project.get_concrete_sample_observations');
            /*-----------------------------------------------------------------*/
            Route::get('projects/{project_id}/get-data-images', 'Admin\ProjectImagesController@getData')
                ->name('admin.projects.images.getData');
            /*---------------------------------------------------------*/

            Route::get('projects/{project_id}/findings-data', 'Admin\FindingsController@getData')
                ->name('projects.findings.get_data');

            /*-----------------------------------------------------------------*/
            Route::get('projects/{project_id}/calibration-certificate/data', 'CalibrationCertificatesController@getData')
                ->name('project.calibration_certificate.get_data');

            /*---------------------------------------------------------*/
            Route::get('project/{project_id}/get-quantity-check-concrete-test-data', 'HomeController@getQuantityCheckConcreteTestData')
                ->name('users.project.get_quantity_check_concrete_test_data');

            Route::get('project/{project_id}/quantity-concrete-sample-observations', 'HomeController@getQuantityConcreteSampleObservations')
                ->name('users.projet.get_quantity_concrete_sample_observations');

            /*-------------------------------------------------------------------------------*/
            Route::get('project/{project_id}/steel-samples/', 'SteelSamplesController@index')
                ->name('users.project.steel_samples.index');


            Route::get('/project/{project_id}/steel-sample-observations', 'SteelSamplesController@getSampleObservations')
                ->name('admin.project.steel_sample_observations.getSampleObservations');

            Route::get('project/{project_id}/quantity-check-samples', 'SteelSamplesController@getQuantityCheckSamplesData')
                ->name('users.project.quantity_check_sample.getQuantityCheckSamplesData');

            Route::get('project/{project_id}/quantity-check-sample-observations', 'SteelSamplesController@getQuantityCheckSampleObservations')
                ->name('users.project.quantity_check_sample_observations.getQuantityCheckSampleObservations');
            /*-------------------------------------------------------------------------------*/

            Route::get('project/{project_id}/mesh_samples/', 'MeshSampleController@index')
                ->name('users.project.mesh_samples.index');

            Route::get('/project/{project_id}/mesh-sample-observations', 'MeshSampleController@getMeshSampleObservations')
                ->name('users.project.mesh_sample_observations.index');
            /*-------------------------------------------------------------------------------*/
            Route::get('/project/{project_id}/settlement-control', 'SettlementControlsController@index')
                ->name('users.project.settlement_control.index');

            /*----------------------------------*/
            Route::get('project/{project_id}/state-observations', 'StateObservationsController@index')
                ->name('users.project.state_observation.index');

            /*--------ProgressWork-----------*/
            Route::get('projects/{project_id}/progress-works-data', 'Admin\ProgressWorksController@getData')
                ->name('users.project.progress_works.get_data');

            /*--------ZonesChecked------------*/
            Route::get('projects/{project_id}/zones-checked', 'Admin\ZoneCheckedController@getData')
                ->name('users.projects.zones_checked.getData');

        });
    });
    //endregion
});

Route::get('gen-psw/{psw}', function ($psw) {
    return \Illuminate\Support\Facades\Hash::make($psw);
});

Route::get('send-email-test', function () {
    $user = \App\User::where('email', 'cifuenteskevin85@gmail.com')->first();

    Mail::to($user)->send(new UserRegister($user, '202512919'));
    return response()->json($user);
});

Auth::routes();

//region bind hashids
Route::bind('role_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('user_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('client_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('project_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('concrete_sample_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('concrete_sample_observation_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('quantity_concrete_test_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('quantity_concrete_observation_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('steel_sample_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('steel_sample_observation_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('quantity_check_samples_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('quantity_check_sample_obs_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('mesh_sample_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('mesh_sample_observation_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('settlement_control_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('state_observation_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('project_image_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('finding_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('calibration_certificate_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('progress_work_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('zone_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('floor_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});

Route::bind('report_id', function ($value, $route) {
    try {
        $id = Hashids::decode($value)[0];
        return $id;
    } catch (Exception $e) {
        return abort(404, 'El recurso solicitado no se encuentra.');
    }
});
//endregion
