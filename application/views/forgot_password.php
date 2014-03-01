<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->lang->line('forgot') . ' ' . $this->lang->line('password'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo IMAGE_URL . 'favicon.ico'; ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo IMAGE_URL . 'favicon.ico'; ?>" type="image/x-icon">
        <!-- Bootstrap -->
        <link href="<?php echo CSS_URL; ?>bootstrap.css" rel="stylesheet" media="screen">
        <!-- custom -->
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet" media="screen">
        <link href="<?php echo CSS_URL; ?>signin.css" rel="stylesheet" media="screen">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.js"></script>
        <![endif]-->
    </head>
    <body>
        <!--Header-->
        <div class="row padding-killer margin-killer login-page-header">
            <div class="container padding-killer">
                <div class="project-logo-area">
                    <div class="text-center">
                        <img src="<?php echo IMAGE_URL . 'logo.png'; ?>" class="logo-img"/>
                    </div>
                </div>
            </div>   	
        </div>
        <!--/Header-->

        <!-- container -->
        <div class="container">
            <div class="login-box-style">
                <form class="form-signin" action="<?php echo ADMIN_BASE_URL; ?>forgot_password_listener" method="post">
                    <legend><h1><?php echo $this->lang->line('forgot') . ' ' . $this->lang->line('password'); ?></h1></legend>
                    <div class="col-lg-12 margin-killer padding-killer">
                        <?php if ($this->session->flashdata('error') != '' || $this->session->flashdata('success') != '') { ?>
                            <?php
                            if ($this->session->flashdata('error') != '') {
                                echo '<div class="alert alert-danger"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('error') . '</div>';
                            }
                            ?>

                            <?php
                            if ($this->session->flashdata('success') != '') {
                                echo '<div class="alert alert-success"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('success') . '</div>';
                            }
                            ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 margin-killer padding-killer">
                        <span class="login-box-label col-md-12 margin-killer padding-killer">
                            <?php echo $this->lang->line('mail_address'); ?>
                        </span>
                        <input name="email_address" type="text" class="form-control col-md-12" placeholder="Username" autofocus value="<?php echo set_value('email_address'); ?>" autocomplete="off">
                        <span class="text-danger"><?php echo form_error('email_address'); ?></span>
                    </div>
                    <div class="col-lg-12 margin-killer padding-killer">
                        <br>
                        <span class="pull-left">
                            <a href="<?php echo ADMIN_BASE_URL . 'login'; ?>">
                                <?php echo $this->lang->line('back_to') . ' ' . $this->lang->line('login'); ?>
                            </a>
                        </span>
                        <span class="pull-right">
                            <button class="btn btn-primary btn-lg pull-right" type="submit">
                                <?php echo $this->lang->line('send'); ?>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <!-- /container -->

        <!-- footer -->
        <div class="container text-center footer-style">
            <span class="footer-text"><br>Powered By <a href="http://www.devrepublic.nl/">Devrepublic</a>.</span>
        </div>
        <!-- /footer -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo JS_URL; ?>jq.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
    </body>
</html>