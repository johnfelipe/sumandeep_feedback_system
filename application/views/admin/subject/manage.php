<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_subject").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$subject_detail[0]->subjectid != '')? 'Edit ' : 'Add New ';?> Subject for : <?php echo @$sem_detail[0]->semester_name .' of ' . @$course_detail[0]->course_name; ?></h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'subject/mangedata' ?>" method="post" id="manage_subject" class="form-horizontal">
        <input type="hidden" value="<?php echo @$subject_detail[0]->subjectid; ?>" name="subjectid" />
        <input type="hidden" value="<?php echo @$sem_detail[0]->sid; ?>" name="sid" />
        <div class="form-group">
            <label for="sem_name" class="col-md-2 control-label">
                Subject Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="subject_name" required="required" value="<?php echo @$subject_detail[0]->subject_name; ?>" class="form-control" placeholder="Subject Name"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'subject/' . @$sem_detail[0]->sid;  ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>