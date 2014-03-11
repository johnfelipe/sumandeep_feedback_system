<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "admin/dashboard/index";
$route['404_override'] = '';

$route['login'] = "authenticate/index";
$route['logout'] = "authenticate/logout";
$route['validate'] = "authenticate/validateUser";


//Course
$route['admin/course/delete/(:num)'] = "admin/course/deleteListener/$1";

//semester
$route['admin/semester/(:num)'] = "admin/semester/index/$1";
$route['admin/semester/getJson/(:num)'] = "admin/semester/getJson/$1";
$route['admin/semester/delete/(:num)'] = "admin/semester/deleteListener/$1";

//Subject
$route['admin/subject/(:num)'] = "admin/subject/index/$1";
$route['admin/subject/getJson/(:num)'] = "admin/subject/getJson/$1";
$route['admin/subject/delete/(:num)'] = "admin/subject/deleteListener/$1";

//Faculty
$route['admin/faculty/delete/(:num)'] = "admin/faculty/deleteListener/$1";

//Faculty
$route['admin/student/delete/(:num)'] = "admin/student/deleteListener/$1";


//Feedback Paramerts
$route['admin/feedback_parameter/status/(:num)'] = "admin/feedback_parameter/changeStatus/$1";
$route['admin/feedback_parameter/role/(:num)'] = "admin/feedback_parameter/changeRole/$1";

//Topic 
$route['admin/topic/(:num)/(:num)'] = "admin/topic/index/$1/$2";

//Change Password Student
$route['student/password_change'] = "student/profile/changePassword";

//Change Password faculty
$route['faculty/password_change'] = "faculty/profile/changePassword";


//reports
$route['admin/report/login/view/(:any)'] = "admin/login_report/index/$1";
$route['admin/report/login/getJson/(:any)'] = "admin/login_report/getJson/$1";
$route['admin/report/login/getJsonForNoLogin/(:any)'] = "admin/login_report/getJsonForNoLogin/$1";

//Feedback of Student By Faculty
$route['admin/report/feedback/student'] = "admin/feedback/ViewStudentFeedback";
$route['admin/report/feedback/student_subjectwise'] = "admin/feedback/subjectWiseStudentFeedBack";
$route['admin/report/feedback/student_subjectwiselistener'] = "admin/feedback/subjectwiselistener";
$route['admin/report/feedback/student_facultywise'] = "admin/feedback/facultyWiseStudentFeedBack";
$route['admin/report/feedback/student_facultywiselistener'] = "admin/feedback/facultywiselistener";

//Feedback of Faculty By Student
$route['admin/report/feedback/faculty_over_all'] = "admin/feedback/faculty_over_all";
$route['admin/report/feedback/faculty_studentwise'] = "admin/feedback/studentWiseFacultyFeedBack";
$route['admin/report/feedback/facultyOverAllListener'] = "admin/feedback/facultyOverAllListener";
$route['admin/report/feedback/facultyStudentWiseListener'] = "admin/feedback/facultyStudentWiseListener";
/* End of file routes.php */
/* Location: ./application/config/routes.php */