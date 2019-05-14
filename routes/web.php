<?php
// Pages and Actions available for Everyone //
Route::get('/',                                                 'All\PageController@showLanding');                          // IN-PROGRESS - professional landing page
// END //

// Pages and Actions available ONLY for GUESTS //
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register',                                     'Guest\PageController@showRegister');                       // READY
    Route::get('/login',                                        'Guest\PageController@showLogin')->name('login');           // READY
    Route::get('/forgotten_password',                           'Guest\PageController@showForgottenPassword');              // READY
    Route::post('/user/register',                               'Guest\ActionController@register');                         // READY
    Route::post('/user/login',                                  'Guest\ActionController@login');                            // READY
    Route::post('/user/resetPassword',                          'Guest\ActionController@resetPassword');                    // READY
});
// END //

// Pages and Actions available ONLY for LECTURERS and ADMINS //
Route::group(['middleware' => 'lecturer'], function () {
    Route::get('/dashboard',                                    'Lecturer\PageController@showDashboard');                   // READY
    Route::get('/modules',                                      'Lecturer\PageController@showModules');                     // READY
    Route::get('/modules/{id}',                                 'Lecturer\PageController@showModule');                      // READY
    Route::get('/modules/{id}/exams',                           'Lecturer\PageController@showModuleExams');                 // READY
    Route::get('/modules/{id}/exams/{examId}',                  'Lecturer\PageController@showModuleExam');                  // READY
    Route::get('/modules/{id}/questions',                       'Lecturer\PageController@showModuleQuestions');             // READY
    Route::get('/modules/{id}/questions/{questionId}',          'Lecturer\PageController@showModuleQuestion');              // READY
    Route::get('/new_question',                                 'Lecturer\PageController@showNewQuestion');                 // READY
    Route::get('/new_exam',                                     'Lecturer\PageController@showNewExam');                     // READY
    Route::get('/printExam/{id}/{type}',                        'Lecturer\PageController@printExam');                       // READY

    Route::get('/logout',                                       'Lecturer\ActionController@logout');                        // READY
    Route::post('/user/createExam',                             'Lecturer\ActionController@createExam');                    // READY
    Route::post('/user/deleteExam',                             'Lecturer\ActionController@deleteExam');                    // READY
    Route::post('/user/updateExam',                             'Lecturer\ActionController@updateExam');                    // READY
    Route::post('/user/removeQuestionFromExam',                 'Lecturer\ActionController@removeQuestionFromExam');        // READY
    Route::post('/user/addQuestionToExam',                      'Lecturer\ActionController@addQuestionToExam');             // READY
    Route::post('/user/createQuestion',                         'Lecturer\ActionController@createQuestion');                // READY
    Route::post('/user/deleteQuestion',                         'Lecturer\ActionController@deleteQuestion');                // READY
    Route::post('/user/updateQuestion',                         'Lecturer\ActionController@updateQuestion');                // READY
    Route::post('/user/removeImageFromQuestion',                'Lecturer\ActionController@removeImageFromQuestion');       // READY
    Route::get('/exportExam/{id}/{type}',                       'Lecturer\ActionController@exportExam');                    // READY
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin',                                        'Admin\PageController@showDashboard');                      // READY
    Route::get('/admin/lecturers',                              'Admin\PageController@showLecturers');                      // READY
    Route::get('/admin/lecturers/new',                          'Admin\PageController@showNewLecturer');                    // READY
    Route::get('/admin/lecturers/{id}',                         'Admin\PageController@showLecturer');
    Route::get('/admin/admins',                                 'Admin\PageController@showAdmins');                         // READY
    Route::get('/admin/admins/new',                             'Admin\PageController@showNewAdmin');                       // READY
    Route::get('/admin/courses',                                'Admin\PageController@showCourses');                        // READY
    Route::get('/admin/courses/new',                            'Admin\PageController@showNewCourse');                      // READY
    Route::get('/admin/courses/{id}',                           'Admin\PageController@showCourse');
    Route::get('/admin/modules',                                'Admin\PageController@showModules');                        // READY
    Route::get('/admin/modules/new',                            'Admin\PageController@showNewModule');                      // READY
    Route::get('/admin/modules/{id}',                           'Admin\PageController@showModule');

    Route::get('/admin/logout',                                 'Admin\ActionController@logout');                           // READY
    Route::post('/admin/createLecturer',                        'Admin\ActionController@createLecturer');                   // READY
    Route::post('/admin/deleteLecturer',                        'Admin\ActionController@deleteLecturer');
    Route::post('/admin/updateLecturer',                        'Admin\ActionController@updateLecturer');
    Route::post('/admin/createAdmin',                           'Admin\ActionController@createAdmin');                      // READY
    Route::post('/admin/createCourse',                          'Admin\ActionController@createCourse');
    Route::post('/admin/deleteCourse',                          'Admin\ActionController@deleteCourse');                     // READY
    Route::post('/admin/updateCourse',                          'Admin\ActionController@updateCourse');
    Route::post('/admin/createModule',                          'Admin\ActionController@createModule');                     // READY
    Route::post('/admin/deleteModule',                          'Admin\ActionController@deleteModule');
    Route::post('/admin/updateModule',                          'Admin\ActionController@updateModule');
});
// END //
