<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate();

        //$('#timepicker1').timepicker();

        $("#course_detials").change(function() {
            var cid = $('#course_detials').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo FACULTY_URL; ?>feedback/getSemesterDetails/' + cid,
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
                url: '<?php echo FACULTY_URL; ?>feedback/getSubjectDetails/' + sid,
                success: function(data)
                {

                    $('#subject_details').empty();
                    $('#subject_details').append(data);

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo FACULTY_URL; ?>feedback/getStudentDetails/' + sid,
                        success: function(data)
                        {
                            $('#student_list').empty();
                            $('#student_list').html(data);
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

        $("#subject_details").change(function() {
            var subjectid = $('#subject_details').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo FACULTY_URL; ?>feedback/getTopicDetails/' + subjectid,
                success: function(data)
                {
                    $('#topic_details').empty();
                    $('#topic_details').append(data);
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
    <h3>New Feedback</h3>
    <hr>

    <form action="<?php echo FACULTY_URL . 'feedback/save' ?>" method="post" id="manage" class="form-horizontal">
        <input type="hidden" value="<?php echo @$faculty_detail[0]->userid; ?>" name="userid" />

        <div class="col-md-12 pull-left">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label"></label>
                    <div class="col-md-8"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Date
                        <span class="text-danger">&nbsp;</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="date" readonly="readonly" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db())); ?>" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 pull-left">
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
                        Session Topic
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="topicid" id="topic_details">
                            <option value="">Select Topic</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Time from
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input id="timepicker1" type="text" class="form-control required">
                        <span class="add-on"><i class="icon-time"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Time to
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input id="timepicker1" type="text" class="form-control required">
                        <span class="add-on"><i class="icon-time"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="col-md-12" id="student_list">
        </div>


        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo FACULTY_URL . 'feedback' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>