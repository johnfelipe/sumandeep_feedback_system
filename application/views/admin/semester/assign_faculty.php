<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3>Assign Faculties for <?php echo @$sem_detail[0]->semester_name . ' of ' . @$course_detail[0]->course_name; ?></h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'semester/assign_faculty_details' ?>" method="post" id="manage" class="form-horizontal">
        <input type="hidden" name="sid" value="<?php echo @$sem_detail[0]->sid; ?>" />
        <input type="hidden" name="cid" value="<?php echo @$course_detail[0]->cid; ?>" />
            
        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <?php foreach ($faculty_details as $faculty) { ?>
                <input type="checkbox" name="assign_faculty[]" value="<?php echo $faculty->userid; ?>" <?php if(in_array($faculty->userid, $assign_faculty)) { echo 'checked="checked"'; } ?>/>
                    <?php echo $faculty->fullname; ?>
                    <br />
                <?php } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'semester/' . @$course_detail[0]->cid; ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </form>
</div>