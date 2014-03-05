<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage_student").validate({
            rules: {
                confirm_password: {
                    equalTo: "#password"
                }
            }
        });
<?php
if (@$semester_detail[0]->sid != '') {
    $userid = 0;
    if (@$student_detail[0]->userid != '') {
        $userid = @$student_detail[0]->userid;
    }
    ?>
            getSemester(<?php echo @$semester_detail[0]->cid . ',' . $userid; ?>);
<?php } ?>

        $("#course_detials").change(function() {

<?php if (@$student_detail[0]->userid != '') { ?>
                var userid = '<?php echo @$student_detail[0]->userid; ?>';
<?php } else { ?>
                var userid = '0';
<?php } ?>
            getSemester($('#course_detials').val(), userid);
        });
    });
    function getSemester(cid, userid) {
        $.ajax({
            type: 'GET',
            url: '<?php echo ADMIN_URL; ?>student/getSemesterDetails/' + cid + '/' + userid,
            success: function(data)
            {
                $('#semester_details').empty();
                $('#semester_details').append(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('error');
            }
        });
    }
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$student_detail[0]->userid != '') ? 'Edit ' : 'Add New '; ?> Student</h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'student/mangedata' ?>" method="post" id="manage_student" class="form-horizontal">
        <input type="hidden" value="<?php echo @$student_detail[0]->userid; ?>" name="userid" />
        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Full Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="student_name" required="required" value="<?php echo @$student_detail[0]->fullname; ?>" class="form-control" placeholder="Full Name"/>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                User Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="student_username" required="required" value="<?php echo @$student_detail[0]->username; ?>" class="form-control" placeholder="User Name" autocomplete="off"/>
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
                Course
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <select class="form-control required" name="cid" id="course_detials">
                    <option value="">Select Course</option>
                    <?php foreach ($course_details as $value) { ?>
                        <option value="<?php echo $value->cid; ?>" <?php echo (@$semester_detail[0]->cid == $value->cid) ? 'selected="selected"' : ''; ?>><?php echo $value->course_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Semester
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <select class="form-control required" name="sid" id="semester_details">
                    <?php if (@$semester_detail[0]->sid != '') { ?>
                        <option value="<?php echo @$semester_detail[0]->sid; ?>"><?php echo @$semester_detail[0]->semester_name . ' (' . @$semester_detail[0]->batch . ')'; ?></option>
                    <?php } else { ?>
                        <option value="">Select Semester</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="question" class="col-md-2 control-label">
                Status
                <span class="text-danger">&nbsp;</span>
            </label>
            <div class="col-md-4">
                <input type="radio" name="status"  value="A" <?php echo (@$student_detail[0]->status == 'A') ? 'checked="checked"' : ''; ?>/> Active
                <input type="radio" name="status"  value="D" <?php echo (@$student_detail[0]->status == 'D') ? 'checked="checked"' : ''; ?>/> Deactive
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'student' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>