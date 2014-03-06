<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate();

        $('#topic_time_from').timepicker({hourMin: 9, hourMax: 17});
        $('#topic_time_to').timepicker({hourMin: 9, hourMax: 17});

        $("#subject_details").change(function() {
            var subjectid = $('#subject_details').val();
            $.ajax({
                type: 'GET',
                url: '<?php echo STUDENT_URL; ?>feedback/getTopicDetails/' + subjectid,
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

    <form action="<?php echo STUDENT_URL . 'feedback/save' ?>" method="post" id="manage" class="form-horizontal">
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
                        <input type="text" name="feedback_date" readonly="readonly" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db())); ?>" class="form-control"/>
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
                            <?php foreach ($subject_list as $subject) { ?>
                                <option value="<?php echo $subject->subjectid; ?>"><?php echo $subject->subject_name; ?></option>
                            <?php } ?>
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

        <div class="col-md-12 pull-left">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label">
                        Faculty 
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <select class="form-control required" name="facultyid">
                            <option value="">Select Faculty</option>
                            <?php foreach ($faculty_list as $faculty) { ?>
                                <option value="<?php echo $faculty->userid; ?>"><?php echo $faculty->fullname; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="question" class="col-md-4 control-label"></label>
                    <div class="col-md-8"></div>
                </div>
            </div>
        </div>

        <div class="clear"></div>

        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Sr No.</th>
                    <th>Parameters</th>
                    <th>&nbsp;</th>
                </tr>
                <?php
                $i = 1;
                foreach ($parameters_list as $param) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $param->parameter_name; ?></td>
                        <td class="text-center">
                            <div id="<?php echo 'ratting_' . $param->paramterid; ?>" class="ratting text-center"></div>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>


        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo STUDENT_URL . 'feedback' ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>
<script>
    $('div.ratting').raty({click: function(score, evt) {
            $("#" + $(this).attr('id') + " :input").attr('name', $(this).attr('id'));
        }
    });
</script>