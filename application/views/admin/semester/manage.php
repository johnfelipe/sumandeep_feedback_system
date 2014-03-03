<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_course").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$sem_detail[0]->sid != '')? 'Edit ' : 'Add New ';?> Semester for : <?php echo @$course_detail[0]->course_name; ?></h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'semester/mangedata' ?>" method="post" id="manage_course" class="form-horizontal">
        <input type="hidden" value="<?php echo @$course_detail[0]->cid; ?>" name="cid" />
        <input type="hidden" value="<?php echo @$sem_detail[0]->sid; ?>" name="sid" />
        <div class="form-group">
            <label for="sem_name" class="col-md-2 control-label">
                Semester Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="sem_name" required="required" value="<?php echo @$sem_detail[0]->semester_name; ?>" class="form-control" placeholder="Semester Name"/>
            </div>
        </div>
        
        <div class="form-group">
            <label for="sem_batch" class="col-md-2 control-label">
                Semester Batch
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="sem_batch" required="required" value="<?php echo @$sem_detail[0]->batch; ?>" class="form-control" placeholder="Semester Batch"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'semester/' . @$course_detail[0]->cid;  ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>