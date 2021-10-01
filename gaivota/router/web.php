<?php
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

Route::get('/login-remote', 'Timestamp\Time@chama')->name('time');
Route::get('/time-doc/{id}', 'Timestamp\Time@enviarDoc')->name('timeDoc');
Route::get('/receive-timestamp', 'Timestamp\Time@downloadTimeStamp')->name('downloadTimeStamp');


Route::get('/welcome', function () {
	return view('welcome');
});

Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	return '<h1>Cache facade value cleared</h1>';
});
Route::get('/optimize', function () {
	$exitCode = Artisan::call('optimize');
	return '<h1>Reoptimized class loader</h1>';
});
Route::get('/route-cache', function () {
	$exitCode = Artisan::call('route:cache');
	return '<h1>Routes cached</h1>';
});
Route::get('/route-clear', function () {
	$exitCode = Artisan::call('route:clear');
	return '<h1>Route cache cleared</h1>';
});
Route::get('/view-clear', function () {
	$exitCode = Artisan::call('view:clear');
	return '<h1>View cache cleared</h1>';
});
Route::get('/config-cache', function () {
	$exitCode = Artisan::call('config:cache');
	return '<h1>Clear Config cleared</h1>';
});

/*
|--------------------------------------------------------------------------
| Site
|--------------------------------------------------------------------------
*/

Route::get('/', 'Site\Home@index')->name('homePage');
Route::get('/sobre-nos', 'Site\Home@sobreNos')->name('sobrePage');
Route::get('/afmachado', 'Site\Home@assinaturaAF')->name('afmachadoPage');
Route::get('/aviso-legal', 'Site\Home@avisoLegal')->name('avisoLegalPage');
Route::get('/255bonfim-1', 'Site\Home@bonfimPage')->name('bonfimPage');




Route::get('/c', 'Site\Contact@index')->name('contactPage');

Route::get('/escura/4', 'Site\Lote4@index')->name('lote4Page');
Route::get('/escura/5', 'Site\Lote5@index')->name('lote5Page');
Route::get('/escura/7', 'Site\Lote7@index')->name('lote7Page');
Route::get('/escura/10', 'Site\Lote10@index')->name('lote10Page');




Route::post('/contact', 'Site\Contact@formContactos')->name('contactForm');
Route::post('/contact-Lote', 'Site\Lote4@formContactosLote')->name('contactLoteForm');
Route::post('/contact-subscreve', 'Site\Lote10@formSubscrever')->name('subscribeForm');

Route::post('/enviar', 'Site\Contact@sendMail')->name('sendEmail');


/*BONFIM*/
Route::get('/bonfim-informacao', 'Site\Bonfim@index')->name('bonfimInfoPage');
Route::get('/bonfim-apartamento/{id}', 'Bonfim\Apartamento@index')->name('bonfimApartamentosPage');
Route::get('/bonfim-localizacao', 'Bonfim\Localizacao@index')->name('bonfimLocalizacaoPage');
Route::get('/bonfim/noticia/{id}', 'Bonfim\Noticia@index')->name('bonfimNoticiaPage');

Route::post('/bonfim-contact', 'Site\Bonfim@formContactos')->name('contactBonfimForm');
Route::post('/bonfim-newsletter', 'Site\Bonfim@formNewslleter')->name('newsletterBonfimForm');


/*
|--------------------------------------------------------------------------
| Carregadores Eletricos
|--------------------------------------------------------------------------
*/
Route::get('/ceagentes', 'Carregadores\Home@index')->name('CarregadoresPage');
Route::get('/cegaivota', 'Carregadores\Home@cepagente')->name('CarregadoresAgentePage');

Route::group(['middleware' => ['Carregadores']], function () {
	Route::get('/cemodelonegocio', 'Carregadores\Home@cepoagente')->name('CarregadoresAgenteOPage');
	Route::post('/login-code', 'Carregadores\Home@loginCode')->name('loginCodePost');
});


/*
|--------------------------------------------------------------------------
| Backoffice
|--------------------------------------------------------------------------
*/


/* BACKOFFICE */
Route::group(['prefix' => 'admin'], function () {
	Route::get('/', 'Backoffice\Login@index')->name('loginPageB');
	Route::post('/', 'Backoffice\Login@loginForm')->name('loginFormB');
	Route::get('/logout', 'Backoffice\Login@logout')->name('logoutPageB');
	Route::get('/lang/{lang}', 'Backoffice\Language@getLang')->name('setLanguageB');
	//restore
	Route::post('/restore', 'Backoffice\Login@restoreForm')->name('restoreFormB');
	Route::get('/restore-password/{token}', 'Backoffice\Login@restorePasswordPage')->name('emailRestorePageB');
	Route::post('/restore-password-form', 'Backoffice\Login@restorePasswordForm')->name('restorePasswordFormB');
	Route::get('/new-admin/{token}', 'Backoffice\Login@restorePasswordPage')->name('emailNewAdminPageB');

	/* BACKOFFICE - ÁREA RESERVADA */
	Route::group(['middleware' => ['Backoffice']], function () {
		Route::get('/dashboard', 'Backoffice\Dashboard@index')->name('dashboardPageB');

		//Administradores
		Route::get('/admins', 'Backoffice\Admins@index')->name('adminPageB');
		Route::get('/new-admin', 'Backoffice\Admins@adminNew')->name('adminNewPageB');
		Route::get('/edit-admin/{id}', 'Backoffice\Admins@adminEdit')->name('adminEditPageB');

		Route::post('/admin-delete', 'Backoffice\Admins@adminApagar')->name('adminAllApagarB');
		Route::post('/admin-form', 'Backoffice\Admins@adminForm')->name('adminFormB');

		//Apartamentos
		Route::get('/apartments', 'Backoffice\Apartments@index')->name('apartmentsPageB');
		Route::get('/new-apartment', 'Backoffice\Apartments@newApart')->name('newApartmentsPageB');
		Route::get('/edit-apartment/{id}', 'Backoffice\Apartments@editApart')->name('editApartmentsPageB');
		Route::get('/finish-map/{id_apartamento}', 'Backoffice\Apartments@map')->name('mapPageB');
		Route::get('/map-edit/{id}', 'Backoffice\Apartments@mapEdit')->name('mapEditPageB');

		Route::post('/form-apartment', 'Backoffice\Apartments@formApart')->name('apartmentsFormB');
		Route::post('/form-map', 'Backoffice\Apartments@formMap')->name('mapFormB');
		Route::post('/form-map-edit', 'Backoffice\Apartments@formMapEdit')->name('mapEditFormB');

		//Noticias
		Route::get('/news', 'Backoffice\News@index')->name('newsPageB');
		Route::get('/new-news', 'Backoffice\News@newNews')->name('newNewsPageB');
		Route::get('/edit-new/{id}', 'Backoffice\News@editNews')->name('editNewsPageB');
		Route::post('/form-new', 'Backoffice\News@formNew')->name('newFormB');

		//Newsletter
		Route::get('/newsletter', 'Backoffice\Newsletter@index')->name('newsletterPageB');
		Route::get('/newsletter-send', 'Backoffice\Newsletter@sendNewsletter')->name('newsletterSendPageB');
		Route::get('/newsletter-edit/{id}', 'Backoffice\Newsletter@editNewsletter')->name('newsletterEditPageB');
		Route::get('/newsletter-view/{id}', 'Backoffice\Newsletter@viewNewsletter')->name('newsletterViewPageB');
		Route::get('/newsletter-emails', 'Backoffice\Newsletter@emailsNewsletter')->name('newsletterEmailsPageB');
		Route::get('/newsletter-new-contact', 'Backoffice\Newsletter@newContactNewsletter')->name('newContactNewsletterPageB');

		Route::post('/newsletter-create', 'Backoffice\Newsletter@createNewsletter')->name('newsletterCreatePostB');
		Route::post('/newsletter-delete', 'Backoffice\Newsletter@deleteNewsletter')->name('newsletterDeletePostB');
		Route::post('/newsletter-send-new', 'Backoffice\Newsletter@sendEmailNewsletter')->name('newsletterSendEmailPostB');
		Route::post('/newsletter-new-contact-form', 'Backoffice\Newsletter@newContactForm')->name('newContactNewsletterPostB');

		//Contactos
		Route::get('/contacts', 'Backoffice\Contacts@index')->name('contactsPageB');
		Route::get('/contact/{id}', 'Backoffice\Contacts@details')->name('contactsDetailsPageB');

		//Site- Informação
		Route::get('/website-info', 'Backoffice\Website@index')->name('websitePageB');
		Route::get('/add-img-projeto', 'Backoffice\Website@addImgProjeto')->name('addImgProjetoB');
		Route::get('/edit-img-projeto/{id}', 'Backoffice\Website@editImgProjeto')->name('editImgProjetoB');

		Route::post('/add-img', 'Backoffice\Website@addImgForm')->name('addImgProjetoPost');

		//Site - Timeline
		Route::get('/website-timeline', 'Backoffice\Website@barraP')->name('websiteTimelinePageB');
		Route::post('/website-timeline-edit', 'Backoffice\Website@barraEdit')->name('websiteTimelineEditForm');

		//SITE - GALERIA HOME
		Route::get('/website-galeria', 'Backoffice\Website@galeriaHome')->name('galeriaHomePageB');
		Route::get('/website-galeria-new', 'Backoffice\Website@galeriaHomeNew')->name('galeriaHomeNewPageB');
		Route::post('/website-galeria-post', 'Backoffice\Website@saveGaleriaHome')->name('saveGaleriaHomeForm');

		//Datasheet
		Route::get('/datasheet', 'Backoffice\Datasheet@index')->name('datasheetPageB');
		Route::post('/form-datasheet', 'Backoffice\Datasheet@form')->name('datasheetFormB');

		//_TableManager
		Route::post('/TM-onoff', 'Backoffice\_TableManager@updateOnOff')->name('updateOnOffTMB');
		Route::post('/TM-delLine', 'Backoffice\_TableManager@deleteLine')->name('deleteLineTMB');
		Route::post('/TM-repDel', 'Backoffice\_TableManager@replaceDelete')->name('replaceDeleteTMB');
		Route::post('/TM-sort', 'Backoffice\_TableManager@sortTable')->name('sortTableTMB');
		Route::post('/TM-order', 'Backoffice\_TableManager@orderTable')->name('orderTableTMB');
	});
});


/*SELOS TEMPORAIS*/
Route::get('/selos-temporais', 'Timestamp\Home@index')->name('homeTimePage');
Route::post('/selos-temporais-compra', 'Timestamp\Home@formCompra')->name('formCSelos');
