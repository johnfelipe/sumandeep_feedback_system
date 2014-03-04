<div class="col-md-12">
    <h3>Feedback Detail of : <?php echo @$student_detail[0]->fullname; ?></h3>
    <hr>
    <table class="table table-bordered">
        <?php foreach ($details as $detail) { ?>
            <tr>
                <td colspan="<?php echo count($parameters); ?>">
                    <div class="col-md-12 pull-left">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-md-4 control-label">Faculty</label>
                                <div class="col-md-8"><?php echo $detail['faculty_name']; ?></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-md-4 control-label">
                                    Date
                                </label>
                                <div class="col-md-8">
                                    <?php echo date('d-m-Y', strtotime(@$detail['feedback_master']->feedback_date)); ?>
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
                                    <?php echo @$detail['feedback_master']->subject_name; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-md-4 control-label">
                                    Session Topic
                                </label>
                                <div class="col-md-8">
                                    <?php echo @$detail['feedback_master']->topic_name; ?>
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
                                    <?php echo date('H:i a', strtotime(@$detail['feedback_master']->topic_time_from)) . ' : ' . date('H:i a', strtotime(@$detail['feedback_master']->topic_time_to)); ?>
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
                </td>
            </tr>
            <tr>
                <?php foreach ($parameters as $param) { ?>
                    <td><?php echo $param->parameter_name; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php foreach ($parameters as $param) { ?>
                    <td>
                        <div id="<?php echo 'ratting_' . $param->paramterid . '_' . $detail['studentid']; ?>" class="ratting text-center" data-score = "<?php echo sfs_student_feedback_details_model::getFeedbackRate(@$detail['feedback_master']->student_feedback_id, $detail['studentid'], $param->paramterid); ?>"></div>
                    </td>
                <?php } ?> 
            </tr>
        <?php } ?>
    </table>
</div>



<script>
    $('div.ratting').raty({readOnly: true, score: function() {
            return $(this).attr('data-score');
        }});
</script>