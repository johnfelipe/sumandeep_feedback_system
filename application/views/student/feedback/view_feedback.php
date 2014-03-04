<div class="col-md-12">
    <h3>Feedback Detail of : <?php echo @$feedback_master[0]->fullname; ?></h3>
    <hr>

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
                </label>
                <div class="col-md-8">
                    <?php echo date('d-m-Y', strtotime(@$feedback_master[0]->feedback_date)); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 pull-left">
        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                    Course
                </label>
                <div class="col-md-8">
                    <?php echo @$feedback_master[0]->course_name; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                    Semester
                </label>
                <div class="col-md-8">
                    <?php echo @$feedback_master[0]->semester_name . ' (' . @$feedback_master[0]->batch . ')'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                    Subject
                </label>
                <div class="col-md-8">
                    <?php echo @$feedback_master[0]->subject_name; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                    Session Topic
                </label>
                <div class="col-md-8">
                    <?php echo @$feedback_master[0]->topic_name; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                    Time :       
                </label>
                <div class="col-md-8">
                    <?php echo date('H:i a', strtotime($feedback_master[0]->topic_time_from)) . ' : ' . date('H:i a', strtotime($feedback_master[0]->topic_time_to)); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="question" class="col-md-4 control-label">
                </label>
                <div class="col-md-8">
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Sr. No.</th>
                <th>Parameter</th>
                <th>Ratting</th>
            </tr>


            <?php $i = 1;
            foreach ($parameters as $param) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo ucwords($param->parameter_name); ?></td>
                    <td class="text-center">
                        <div class="ratting text-center" data-score = "<?php echo sfs_faculty_feedback_details_model::getFeedbackRate($feedback_master[0]->faculty_feedback_id, $param->paramterid); ?>"></div>
                    </td>
                </tr>
                <?php $i++;
            } ?>

        </table>
    </div>

</form>
</div>
<script>
    $('div.ratting').raty({readOnly: true, score: function() {
            return $(this).attr('data-score');
        }});
</script>