<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate();

<?php $date = date('m/d/Y', strtotime(get_current_date_time()->get_date_for_db())); ?>
        $("#date_from").datepicker({dateFormat: 'dd-mm-yy', maxDate:<?php echo $date; ?>, changeMonth: true, changeYear: true, yearRange: "1900:<?php echo date('Y'); ?>"});

        $("#date_to").datepicker({dateFormat: 'dd-mm-yy', maxDate:<?php echo $date; ?>, changeMonth: true, changeYear: true, yearRange: "1900:<?php echo date('Y'); ?>"});

        $("#date_from").change(function() {
            $("#date_to").val('<?php echo date('d-m-Y', strtotime($date)); ?>');
        });

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
                url: '<?php echo ADMIN_URL; ?>feedback/getFacultyDetails/' + sid,
                success: function(data)
                {

                    $('#faculty_details').empty();
                    $('#faculty_details').append(data);
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

    <form action="<?php echo ADMIN_URL . 'report/feedback/student_facultywiselistener'; ?>" method="post" id="manage">
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
        <div class="clear"></div>
        <div class="row">
            &nbsp;
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Faculty
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="facultyid" id="faculty_details">
                            <option value="">Select Faculty</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        &nbsp;
                        <span class="text-danger">&nbsp;</span>
                    </label>
                    <div class="col-md-8">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row text-center">
            &nbsp;
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Date From
                        <span class="text-danger">&nbsp;</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="date_from" id="date_from" class="form-control" placeholder="Date From" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Date To
                        <span class="text-danger">&nbsp;</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="date_to" id="date_to" class="form-control" placeholder="Date To" />
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row">
            &nbsp;
        </div>
        <div class="row text-center">
            <button type="submit" class="btn btn-default">View Feedback</button>
        </div>
    </form>
</div>
