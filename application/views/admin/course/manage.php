<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_course").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3>Add New Course</h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'course/mangedata' ?>" method="post" id="manage_course" class="form-horizontal">
        <input type="hidden" value="<?php echo @$course_detail[0]->cid; ?>" name="cid" />
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Course Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="course_name" required="required" value="<?php echo @$course_detail[0]->course_name; ?>" class="form-control" placeholder="Course Name"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'course' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>