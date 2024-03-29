<!DOCTYPE html>
<html>
    <head>
        <title><?php echo @$page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo IMAGE_URL . 'favicon.ico'; ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo IMAGE_URL . 'favicon.ico'; ?>" type="image/x-icon">
        <!-- Bootstrap -->
        <link href="<?php echo CSS_URL; ?>bootstrap.css" rel="stylesheet" media="screen">
        <!-- custom -->
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet" media="screen">
        <link href="<?php echo CSS_URL; ?>demo_table_jui.css" rel="stylesheet" />
        <link href="<?php echo CSS_URL; ?>jquery-ui.css" rel="stylesheet" />
        <link href="<?php echo CSS_URL; ?>jquery.confirm.css" rel="stylesheet" />
        <link href="<?php echo CSS_URL; ?>DT_bootstrap.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo JS_URL; ?>jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery.confirm.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>DT_bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery.raty.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery-ui.js" type="text/javascript"></script>
        <script src="<?php echo JS_URL; ?>jquery-ui-timepicker-addon.js" type="text/javascript"></script>

        <script type="text/javascript">
            var http_host_js = '<?php echo ADMIN_URL; ?>';
        </script>
    </head>
    <body>
        <div class="container">
            <!--Header-->
            <div class="row padding-killer margin-killer login-page-header">
                <div class="container padding-killer">
                    <div class="project-logo-area">
                        <div class="pull-left">
                            <img src="<?php echo IMAGE_URL . 'logo.png'; ?>" class="logo-img"/>
                        </div>
                    </div>
                </div>   	
            </div>
            <!--/Header-->



            <!--Navigation Bar-->
            <div class="navbar navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo ADMIN_URL . 'course' ?>">Course</a></li>
                        <li><a href="<?php echo ADMIN_URL . 'faculty' ?>">Faculty</a></li>
                        <li><a href="<?php echo ADMIN_URL . 'student' ?>">Student</a></li>
                        <li><a href="<?php echo ADMIN_URL . 'feedback_parameter' ?>">Feedback Parameters</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Reports
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="#">Login</a>
                                    <ul class="dropdown-menu">                                           
                                        <li><a href="<?php echo ADMIN_URL . 'report/login/view/student' ?>">Login Student</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/login/view/no_student' ?>">No Login Student</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/login/view/faculty' ?>">Login Faculty</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/login/view/no_faculty' ?>">No Login Faculty</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="#">Feedback</a>
                                    <ul class="dropdown-menu">                                           
                                        <li><a href="<?php echo ADMIN_URL . 'report/feedback/student_subjectwise' ?>">Student Subject Wise</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/feedback/student_facultywise' ?>">Student Faculty Wise</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/feedback/faculty_over_all' ?>">Faculty Over All</a></li>
                                        <li><a href="<?php echo ADMIN_URL . 'report/feedback/faculty_studentwise' ?>">Faculty Student Wise</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> 

                    </ul>

                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown">
                            <?php $session = $this->session->userdata('feedback_session'); ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php echo @$session->fullname; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'logout'; ?>">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
            <!--/Navigation Bar-->


            <!--Main Container-->
            <div class="">
                <?php echo @$content_for_layout; ?>
            </div>
            <!--Main Container-->

            <div class="text-center footer-style">
                <hr>
                Powered By <a href="http://sumandeepuniversity.co.in">Sumandeep University</a>.
            </div>
        </div>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
    </body>
</html>
