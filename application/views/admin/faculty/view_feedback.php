<div class="col-md-12">
    <h3>Feedback Detail of : <?php echo @$faculty_detail[0]->fullname; ?></h3>
    <hr>

    <?php
    if (count($details) > 0) {
        foreach ($details as $detail) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th colspan="2"><h3><?php echo @$detail['student_name']; ?></h3></th>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="col-md-12 pull-left">
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
                    </td>
                </tr>

                <?php foreach ($parameters as $param) { ?>
                    <tr>
                        <td><?php echo $param->parameter_name; ?></td>
                        <td>
                            <div class="ratting text-center" data-score = "<?php echo sfs_faculty_feedback_details_model::getFeedbackRate(@$detail['feedback_master']->faculty_feedback_id, $param->paramterid); ?>"></div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <br />
        <?php }
    } else {
        echo '<h3 class="text-center">No Feedback given</h3>';
    } ?>

</div>



<script>
    $('div.ratting').raty({readOnly: true, score: function() {
            return $(this).attr('data-score');
        }});
</script>