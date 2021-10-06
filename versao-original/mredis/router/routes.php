<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/welcome', function (){ return view('welcome'); });

################
#     SITE     #
################
Route::get('/v1','Home@index')->name('homePage');
Route::get('/why','Why@index')->name('whyPage');
Route::get('/who','Who@index')->name('whoPage');
Route::get('/portfolio-v1','Portfolio@index')->name('portfolioPage');
Route::get('/mcode-v1','Mcode@index')->name('mcodePage');
Route::get('/contacts','Contacts@index')->name('contactsPage');
Route::post('/contacts', 'Contacts@contactsForm')->name('contactsForm');

###############
#     API     #
###############
Route::group(['prefix' => 'api'], function(){
	Route::get('/', 'Api\Index@index')->name('indexAPI');
	Route::post('/form', 'Api\Index@form')->name('formAPI');

	//receber os esatdos das mensagens em tempo real
	Route::get('/message/{token}/{status}/{date}', 'Api\Index@receiveStatusMessage')->name('receiveStatusMessageAPI');

	Route::get('/all-messages', 'Api\Index@getAll')->name('getAllAPI');
	Route::post('/new-message', 'Api\Index@createNew')->name('createNewAPI');
	Route::get('/get-external', 'Api\Index@getExternal')->name('getExternalAPI');
	Route::get('/log-message', 'Api\Index@logMessage')->name('logMessageAPI');
	Route::get('/status-message', 'Api\Index@statusMessage')->name('statusMessageAPI');
});


#################
#     SITE 2    #
#################

Route::get('/','Site\Home@index')->name('homePageV2');
Route::get('/crianca2021','Site\Home@crianca2021')->name('crianca2021PageV2');
Route::get('/sector-publico','Site\Pub@index')->name('PublicPageV2');
Route::get('/sector-privado','Site\Priv@index')->name('PrivatePageV2');
Route::get('/sobre-nos','Site\Who@index')->name('WhoPageV2');
Route::get('/portfolio','Site\Portfolio@index')->name('portfolioPageV2');
Route::post('/contacto-parceria', 'Site\Priv@contact')->name('formParceria');
Route::get('/contacto','Site\Contacts@index')->name('contactsPageV2');
Route::post('/contacts-form', 'Site\Contacts@contactsForm')->name('contactsFormV2');
Route::get('/mcode','Site\Mcode@index')->name('mcodePageV2');




#####################
#     TIMESTAMPS    #
#####################
Route::get('/timestamp-exemplo', 'Timestamp\Time@index')->name('exemploTime');

Route::get('/timestamp-createDateOAL', 'Timestamp\Time@createDateOAL')->name('createDateOAL');


//Enviar documento

Route::get('/timestampLogin', 'Timestamp\TimeLogin@index')->name('loginTime');
Route::post('/timestamp-login-form', 'Timestamp\TimeLogin@loginPost')->name('loginPostTime');


//Receber documento

Route::post('/timestamp-receive', 'Timestamp\Time@postDocumento')->name('receiveDocument');
Route::get('/pdf/{name_doc}/{timestamp}/{code_file}', 'Timestamp\Time@pdf')->name('pdf');


/*SELOS TEMPORAIS*/
Route::get('/sl', 'Timestamp\Home@index')->name('homeTimePage');
Route::post('/selos-temporais-compra', 'Timestamp\Home@formCompra')->name('formCSelos');

/*SELOS TEMPORAIS - LOGIN*/
Route::get('/sl-login', 'Timestamp\Login@index')->name('loginTimePage');
Route::get('/sl-ativar-conta/{token}', 'Timestamp\Login@ativarConta')->name('ativarContaS');
Route::get('/sl-conta-cancelada', 'Timestamp\Login@ativarConta')->name('ativarContaS');
Route::post('/sl-login-form', 'Timestamp\Login@formLogin')->name('formLSelos');
Route::post('/sl-register-form', 'Timestamp\Login@formRegister')->name('formRSelos');
Route::post('/sl-ativar-conta', 'Timestamp\Login@formAtivarConta')->name('formAtivarContaS');
Route::get('/sl-logout', 'Timestamp\Login@logout')->name('logoutContaS');

/*SELOS TEMPORAIS - AREA CLIENTE*/
Route::group([ 'middleware' => ['Client'] ], function () {
	Route::get('/sl-area-client', 'Timestamp\Client@index')->name('clientTimePage');
	Route::get('/sl-area-client-api', 'Timestamp\Client@api')->name('clientTimeApiPage');

	Route::get('/sl-area-client-pagamentos', 'Timestamp\Client@pagamentos')->name('clientTimePagPage');

	Route::post('/selos-add-conta', 'Timestamp\Client@formAddConta')->name('formAddConta');

});