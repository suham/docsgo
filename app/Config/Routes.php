<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Users');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Users::index', ['filter' => 'noauth']);
$routes->get('logout', 'Users::logout');
$routes->match(['get','post'],'register', 'Users::register', ['filter' => 'noauth']);
$routes->match(['get','post'],'profile', 'Users::profile',['filter' => 'auth']);
$routes->match(['get','post'],'admin/users', 'Users::viewUsers',['filter' => 'auth']);
$routes->post('admin/users/updateStatus', 'Users::updateAdminStatus',['filter' => 'auth']);

$routes->get('dashboard', 'Dashboard::index',['filter' => 'auth']);

$routes->get('projects', 'Projects::index',['filter' => 'auth']);
$routes->match(['get','post'],'projects/add', 'Projects::add',['filter' => 'auth']);
// $routes->match(['get','post'],'projects/add/(:num)', 'Projects::add',['filter' => 'auth']);
// $routes->match(['get','post'],'projects/delete/(:num)', 'Projects::delete',['filter' => 'auth']);

$routes->get('documents-master', 'DocumentsMaster::index',['filter' => 'auth']);
$routes->match(['get','post'],'documents-master/add', 'DocumentsMaster::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents-master/add/(:num)', 'DocumentsMaster::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents-master/delete/(:num)', 'DocumentsMaster::delete',['filter' => 'auth']);

$routes->get('team', 'Team::index',['filter' => 'auth']);
$routes->match(['get','post'],'team/add', 'Team::add',['filter' => 'auth']);
$routes->match(['get','post'],'team/add/(:num)', 'Team::add',['filter' => 'auth']);
$routes->match(['get','post'],'team/delete/(:num)', 'Team::delete',['filter' => 'auth']);

$routes->get('issues', 'Issues::index',['filter' => 'auth']);
$routes->match(['get','post'],'issues/add', 'Issues::add',['filter' => 'auth']);
$routes->match(['get','post'],'issues/add/(:num)', 'Issues::add',['filter' => 'auth']);
$routes->match(['get','post'],'issues/delete/(:num)', 'Issues::delete',['filter' => 'auth']);

$routes->get('cybersecurity', 'Cybersecurity::index',['filter' => 'auth']);
$routes->match(['get','post'],'cybersecurity/add', 'Cybersecurity::add',['filter' => 'auth']);
$routes->match(['get','post'],'cybersecurity/add/(:num)', 'Cybersecurity::add',['filter' => 'auth']);
$routes->match(['get','post'],'cybersecurity/delete/(:num)', 'Cybersecurity::delete',['filter' => 'auth']);

$routes->get('soup', 'Soup::index',['filter' => 'auth']);
$routes->match(['get','post'],'soup/add', 'Soup::add',['filter' => 'auth']);
$routes->match(['get','post'],'soup/add/(:num)', 'Soup::add',['filter' => 'auth']);
$routes->match(['get','post'],'soup/delete/(:num)', 'Soup::delete',['filter' => 'auth']);

$routes->get('risk-assessment', 'RiskAssessment::index',['filter' => 'auth']);
$routes->match(['get','post'],'risk-assessment/add', 'RiskAssessment::add',['filter' => 'auth']);
$routes->match(['get','post'],'risk-assessment/add/(:num)/(:num)', 'RiskAssessment::add',['filter' => 'auth']);
$routes->match(['get','post'],'risk-assessment/delete/(:num)', 'RiskAssessment::delete',['filter' => 'auth']);
$routes->match(['get','post'],'risk-assessment/view/(:num)/(:num)', 'RiskAssessment::view',['filter' => 'auth']);
// $routes->match(['get','post'],'issues/delete/(:num)', 'Issues::delete',['filter' => 'auth']);

$routes->get('requirements', 'Requirements::index',['filter' => 'auth']);
$routes->match(['get','post'],'requirements/add', 'Requirements::add',['filter' => 'auth']);
$routes->match(['get','post'],'requirements/add/(:num)', 'Requirements::add',['filter' => 'auth']);
$routes->match(['get','post'],'requirements/delete/(:num)', 'Requirements::delete',['filter' => 'auth']);

$routes->get('test-cases', 'TestCases::index',['filter' => 'auth']);
$routes->match(['get','post'],'test-cases/add', 'TestCases::add',['filter' => 'auth']);
$routes->match(['get','post'],'test-cases/add/(:num)', 'TestCases::add',['filter' => 'auth']);
$routes->match(['get','post'],'test-cases/delete/(:num)', 'TestCases::delete',['filter' => 'auth']);

$routes->get('traceability-matrix', 'TraceabilityMatrix::index',['filter' => 'auth']);
$routes->match(['get','post'],'traceability-matrix/add', 'TraceabilityMatrix::add',['filter' => 'auth']);
$routes->match(['get','post'],'traceability-matrix/add/(:num)', 'TraceabilityMatrix::add',['filter' => 'auth']);
$routes->match(['get','post'],'traceability-matrix/delete/(:num)', 'TraceabilityMatrix::delete',['filter' => 'auth']);
$routes->match(['get','post'],'traceability-matrix/getIDDescription/(:num)/(:num)', 'TraceabilityMatrix::getIDDescription',['filter' => 'auth']);
$routes->match(['get','post'],'traceability-matrix/getTestCaseDescription/(:num)', 'TraceabilityMatrix::getTestCaseDescription',['filter' => 'auth']);

$routes->get('reviews', 'Reviews::index',['filter' => 'auth']);
$routes->get('reviews/project/(:num)', 'Reviews::projectReview',['filter' => 'auth']);
$routes->match(['get','post'],'reviews/add', 'Reviews::add',['filter' => 'auth']);
$routes->match(['get','post'],'reviews/add/(:num)', 'Reviews::add',['filter' => 'auth']);
$routes->match(['get','post'],'reviews/delete/(:num)', 'Reviews::delete',['filter' => 'auth']);

$routes->get('documents', 'Documents::index',['filter' => 'auth']);
$routes->get('documents/project/(:num)', 'Documents::projectDocument',['filter' => 'auth']);
$routes->match(['get','post'],'documents/add', 'Documents::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents/add/(:num)', 'Documents::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents/delete/(:num)', 'Documents::delete',['filter' => 'auth']);

$routes->get('documents-templates', 'DocumentTemplate::index',['filter' => 'auth']);
$routes->post('documents-templates/addTemplate', 'DocumentTemplate::addTemplate',['filter' => 'auth']);
$routes->match(['get','post'],'documents-templates/add', 'DocumentTemplate::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents-templates/add/(:num)', 'DocumentTemplate::add',['filter' => 'auth']);
$routes->match(['get','post'],'documents-templates/delete/(:num)', 'DocumentTemplate::delete',['filter' => 'auth']);

$routes->get('bulk-insert', 'BulkInsert::index', ['filter' => 'auth']);
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
