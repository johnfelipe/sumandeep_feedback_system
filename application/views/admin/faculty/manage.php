<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_faculty").validate({
            rules: {
                confirm_password: {
                    equalTo: "#password"
                }
            }
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$faculty_detail[0]->userid != '') ? 'Edit ' : 'Add New '; ?> Faculty</h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'faculty/mangedata' ?>" method="post" id="manage_faculty" class="form-horizontal">
        <input type="hidden" value="<?php echo @$faculty_detail[0]->userid; ?>" name="userid" />
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Full Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="faculty_name" required="required" value="<?php echo @$faculty_detail[0]->fullname; ?>" class="form-control" placeholder="Full Name"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                User Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="faculty_username" required="required" value="<?php echo @$faculty_detail[0]->username; ?>" class="form-control" placeholder="User Name" autocomplete="off"/>
            </div>
        </div>


        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Password
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-md-4">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Confirm Password
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-md-4">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password"/>
            </div>
        </div>

        
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Status
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-md-4">
                <input type="radio" name="status"  value="A" <?php echo (@$faculty_detail[0]->status == 'A') ? 'checked="checked"' : ''; ?>/> Active
                <input type="radio" name="status"  value="D" <?php echo (@$faculty_detail[0]->status == 'D') ? 'checked="checked"' : ''; ?>/> Deactive
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'faculty' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>