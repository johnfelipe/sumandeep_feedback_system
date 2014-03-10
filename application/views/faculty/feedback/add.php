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
                url: '<?php echo FACULTY_URL; ?>feedback/getSemesterDetails/' + cid,
                success: function(data)
                {
                    $('#semester_details').empty();
                    $('#semester_details').append(data);
                    $('.show_paramerters').show();
                    $('#dispaly_error').hide();
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
                    $('.show_paramerters').show();
                    $('#dispaly_error').hide();

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo FACULTY_URL; ?>feedback/getStudentDetails/' + sid,
                        success: function(data)
                        {
                            $('#student_list').empty();
                            $('#student_list').html(data);
                            $('.show_paramerters').show();
                            $('#dispaly_error').hide();
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
                    $('.show_paramerters').show();
                    $('#dispaly_error').hide();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('error');
                }
            });
        });

        $("#topic_time_from").change(function() {
            $('.show_paramerters').show();
            $('#dispaly_error').hide();
        });

        $("#topic_time_to").change(function() {
            $('.show_paramerters').show();
            $('#dispaly_error').hide();
        });

        $("#facultyid").change(function() {
            var subjectid = $('#subject_details').val();
            var topicid = $('#topic_details').val();
            var topic_time_from = $('#topic_time_from').val();
            var topic_time_to = $('#topic_time_to').val()
            $.ajax({
                type: 'POST',
                url: '<?php echo STUDENT_URL . 'feedback/checkTime'; ?>',
                data: {
                    subjectid: subjectid,
                    topicid: topicid,
                    topic_time_from: topic_time_from,
                    topic_time_to: topic_time_to,
                },
                success: function(data)
                {
                    if (data === 'true') {
                        $('.show_paramerters').hide();
                        $('#dispaly_error').show();
                    } else {
                        $('.show_paramerters').show();
                        $('#dispaly_error').hide();
                    }

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
        <div class="row">
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
                        <input type="text" name="feedback_date" id="feedback_date" readonly="readonly" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db())); ?>" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
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

        <div class="row">
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

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Time from
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control required" readonly="readonly" name="topic_time_from" id="topic_time_from">
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
                        <input type="text" class="form-control required" readonly="readonly" name="topic_time_to" id="topic_time_to">
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="row" id="student_list">
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