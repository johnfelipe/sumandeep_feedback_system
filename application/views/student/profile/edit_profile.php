<script>
<?php
@$session = $this->session->userdata('feedback_session');
?>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_student").validate({
            rules: {
                student_username: {
                    remote: '<?php echo STUDENT_URL . 'profile/checkusername/' . @$session->userid; ?>'
                },
                email: {
                    remote: '<?php echo STUDENT_URL . 'profile/checkemail/' . @$session->userid; ?>'
                }
            },
            messages: {
                student_username: {
                    remote: 'The Username already exit.'
                },
                email: {
                    remote: 'The Email address already exit'
                }
            },
        })
    });
</script>
<div class="col-md-12">
    <h3>Your Profile</h3>
    <hr>

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

    <form action="<?php echo STUDENT_URL . 'profile/updateProfile' ?>" method="post" id="manage_student" class="form-horizontal">
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Full Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="student_name" required="required" value="<?php echo $profile[0]->fullname; ?>" class="form-control" placeholder="Full Name"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                User Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="student_username" required="required" value="<?php echo $profile[0]->username; ?>" class="form-control" placeholder="User Name" autocomplete="off"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Email Address
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-md-4">
                <input type="email" name="email"  value="<?php echo $profile[0]->email; ?>" class="form-control" placeholder="Email Address" autocomplete="off"/>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-2 control-label">&nbsp;</label>
            <div class="col-md-4">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo STUDENT_URL . 'dashboard' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>