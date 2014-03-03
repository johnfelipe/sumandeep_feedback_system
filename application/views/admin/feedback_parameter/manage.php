<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_parameter").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$feedback_parameter_detail[0]->userid != '') ? 'Edit ' : 'Add New '; ?> Parameter</h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'feedback_parameter/mangedata' ?>" method="post" id="manage_parameter" class="form-horizontal">
        <input type="hidden" value="<?php echo @$feedback_parameter_detail[0]->paramterid; ?>" name="paramterid" />
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Parameter Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="parameter_name" required="required" value="<?php echo @$feedback_parameter_detail[0]->parameter_name; ?>" class="form-control" placeholder="Parameter Name"/>
            </div>
        </div>
        
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Parameter For 
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="radio" name="role"  required="required" value="S" <?php echo (@$feedback_parameter_detail[0]->role == 'S') ? 'checked="checked"' : ''; ?>/> Student
                <input type="radio" name="role"  required="required" value="F" <?php echo (@$feedback_parameter_detail[0]->role == 'F') ? 'checked="checked"' : ''; ?>/> Faculty
            </div>
        </div>
        
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Status
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="radio" name="status"  required="required" value="A" <?php echo (@$feedback_parameter_detail[0]->status == 'A') ? 'checked="checked"' : ''; ?>/> Active
                <input type="radio" name="status"  required="required" value="D" <?php echo (@$feedback_parameter_detail[0]->status == 'D') ? 'checked="checked"' : ''; ?>/> Deactive
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'feedback_parameter' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>