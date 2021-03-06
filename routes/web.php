<?php

// NAControllers
Route::get('callback', 'NAController@callback');
Route::get('login', 'NAController@login');

// Resource Controllers
Route::resource('revision-requests', 'RevisionRequestController');
Route::resource('documents', 'DocumentController');
Route::resource('sections', 'SectionController');
Route::resource('cpars', 'CparController');

// For printing revision-requests
Route::get('revision-requests/{revision_request}/print', 'RevisionRequestController@printRevisionRequest')->name('revision-requests.print');

// Individual Get Requests
Route::get('dashboard', 'PageController@dashboard')->name('pages.dashboard')->middleWare('na.authenticate');
Route::get('action-summary/{cpar}/{date?}', 'PageController@actionSummary')->name('action-summary');
Route::get('answer-cpar/login/{cpar}', 'PageController@answerCparLogin')->name('answer-cpar-login');
Route::get('home', 'PageController@home')->name('pages.home')->middleware('na.authenticate');
Route::get('page-not-found', 'PageController@pageNotFound')->name('page-not-found');
Route::get('answer-cpar/{cpar}', 'CparController@answerCpar')->name('answer-cpar');
Route::get('cpar-closed', 'CparController@cparClosed')->name('cpars.cpar-closed');
Route::get('cpar-on-review/{cpar}', 'CparController@onReview')->name('on-review');
Route::get('cpars/verify/{cpar}', 'CparController@verify')->name('cpars.verify');
Route::get('cpars/finalize-verification/{cpar}', 'CparController@finalize')->name('cpars.finalize');
Route::get('review/{cpar}', 'CparController@review')->name('review');

Route::get('/', function () {
    return view('welcome');
});

// Individual POST Requests
Route::post('answer-cpar/login/{cpar}', 'PageController@answerCparLoginPost')->name('answer-cpar-login-post');
Route::post('cpars/save-as-draft/{cpar}', 'CparController@saveAsDraft')->name('cpars.save-as-draft');
Route::post('cpars/verify/{cpar}', 'CparController@postVerify')->name('cpars.verify.post');
Route::post('cpars/review/{cpar}', 'CparController@saveReview')->name('review-cpar');
Route::post('answer/{cpar}', 'CparController@answer')->name('answer');
