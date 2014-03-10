<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate();

        $('#topic_time_from').timepicker({hourMin: 9, hourMax: 17});
        $('#topic_time_to').timepicker({hourMin: 9, hourMax: 17});

        $("#course_detials").change(function() {
            var cid = $('#course_detials').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL; ?>feedback/getSemesterDetails/' + cid,
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
        });

        $("#semester_details").change(function() {
            var sid = $('#semester_details').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo ADMIN_URL; ?>feedback/getSubjectDetails/' + sid,
                success: function(data)
                {

                    $('#subject_details').empty();
                    $('#subject_details').append(data);
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo ADMIN_URL; ?>feedback/getStudentDetails/' + sid,
                        success: function(data)
                        {
                            $('#student_details').empty();
                            $('#student_details').html(data);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            alert('error');
                        }
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('error');
                }
            });
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3>Feedback Report of Students : Subject Wise</h3>
    <hr>

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

    <?php
    if ($this->session->flashdata('info') != '') {
        echo '<div class="alert alert-info"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('info') . '</div>';
    }
    ?>

    <form action="<?php echo ADMIN_URL . 'report/feedback/student_subjectwiselistener'; ?>" method="post" id="manage">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Course
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="cid" id="course_detials">
                            <option value="">Select Course</option>
                            <?php foreach ($course_details as $value) { ?>
                                <option value="<?php echo $value->cid; ?>"><?php echo $value->course_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Semester
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="sid" id="semester_details">
                            <option value="">Select Semester</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="col-md-12">
            &nbsp;
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Subject
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="subjectid" id="subject_details">
                            <option value="">Select Subject</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Student
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="userid" id="student_details">
                            <option value="0">All Student</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="col-md-12 text-center">
            &nbsp;
        </div>
        <div class="clear"></div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-default">View Feedback</button>
        </div>
    </form>
</div>
