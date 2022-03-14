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
Route::view('/', 'welcome');

Route::resource('awardwinners', 'App\Http\Controllers\AwardController');

Route::resource('champions', 'App\Http\Controllers\ChampionController');

Route::resource('coach', 'App\Http\Controllers\CoachController');

Route::resource('draft', 'App\Http\Controllers\DraftController');

Route::resource('fantasyguide', 'App\Http\Controllers\FantasyGuideController');

Route::resource('hof', 'App\Http\Controllers\HallOfFameController');

Route::resource('mockdraft', 'App\Http\Controllers\MockDraftController');

//START PLAYER

Route::resource('player', 'App\Http\Controllers\PlayerController');

Route::resource('playerprofile', 'App\Http\Controllers\PlayerProController');

Route::resource('playerstats', 'App\Http\Controllers\PlayerStatsController');

Route::resource('playerlog', 'App\Http\Controllers\PlayerLogController');

Route::resource('formerplayer', 'App\Http\Controllers\FormerPlayerController');

//FINISH PLAYER

Route::resource('playoffrounds', 'App\Http\Controllers\PlayoffRoundController');

//START TEAM

Route::resource('team', 'App\Http\Controllers\TeamController');

Route::resource('teamroster', 'App\Http\Controllers\TeamRosterController');

Route::resource('teamstats', 'App\Http\Controllers\TeamStatsController');

Route::resource('teamcontracts', 'App\Http\Controllers\TeamContractsController');

Route::resource('teamschedule', 'App\Http\Controllers\TeamScheduleController');

Route::resource('teamstaff', 'App\Http\Controllers\TeamStaffController');

Route::resource('teaminsights', 'App\Http\Controllers\TeamInsightsController');

Route::resource('teaminfo', 'App\Http\Controllers\TeamInfoController');

Route::get('teamhistory', 'App\Http\Controllers\TeamHistoryController@index');

Route::get('teamhistory/playerhistory/{id}', 'App\Http\Controllers\TeamHistoryController@playerHistory');

Route::get('teamhistory/seasonrecaps/{id}', 'App\Http\Controllers\TeamHistoryController@seasonRecaps');

Route::get('teamhistory/{id}', 'App\Http\Controllers\TeamHistoryController@seasonRecaps');

Route::get('teamhistory/drafthistory/{id}', 'App\Http\Controllers\TeamHistoryController@draftHistory');

Route::get('teamhistory/transactionhistory/{id}', 'App\Http\Controllers\TeamHistoryController@transactionHistory');

Route::get('teamhistory/playerrecords/{id}', 'App\Http\Controllers\TeamHistoryController@playerRecords');

Route::get('teamhistory/coachrecords/{id}', 'App\Http\Controllers\TeamHistoryController@coachRecords');

//FINISH TEAM
Route::resource('toprookies', 'App\Http\Controllers\TopRookieController');

Route::get('schedule/', 'App\Http\Controllers\ScheduleController@index');

Route::get('schedule/game/{id}', 'App\Http\Controllers\ScheduleController@show');

Route::resource('leagueleaders', 'App\Http\Controllers\LeagueLeadersController');

Route::resource('dleagueleaders', 'App\Http\Controllers\DLeagueLeadersController');

Route::resource('teamleagueleaders', 'App\Http\Controllers\TeamLeagueLeadersController');

Route::resource('milestones', 'App\Http\Controllers\MileStonesController');

Route::resource('transactions', 'App\Http\Controllers\TransactionsController');

Route::resource('standings', 'App\Http\Controllers\StandingsController');

Route::resource('dstandings', 'App\Http\Controllers\DStandingsController');

Route::resource('paststandings', 'App\Http\Controllers\PastStandingController');

Route::resource('finances', 'App\Http\Controllers\FinanceController');

Route::resource('medianews', 'App\Http\Controllers\MediaNewController');

Route::resource('search', 'App\Http\Controllers\SearchController');

Route::resource('playersearch', 'App\Http\Controllers\PlayerSearchController');

Route::resource('coachsearch', 'App\Http\Controllers\CoachSearchController');

Route::resource('coachrecords', 'App\Http\Controllers\CoachRecordController');

Route::resource('playerrecords', 'App\Http\Controllers\PlayerRecordController');

Route::resource('freeagencyguide', 'App\Http\Controllers\FreeAgencyGuideController');

Route::resource('rookieguide', 'App\Http\Controllers\RookieGuideController');

Route::resource('awards', 'App\Http\Controllers\AwardHeadlineController');

Route::resource('draftpicks', 'App\Http\Controllers\DraftPickController');

Route::resource('injuryreport', 'App\Http\Controllers\InjuryReportController');

Route::resource('seasonprev', 'App\Http\Controllers\SeasonPrevController');

Route::resource('playerhistory', 'App\Http\Controllers\PlayerHistoryController');



