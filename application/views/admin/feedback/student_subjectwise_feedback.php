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

    <table class="table table-bordered">
        <tr>
            <th><?php echo @$course_detials[0]->course_name; ?></th>
            <th><?php echo @$sem_detials[0]->semester_name . ' (' . @$sem_detials[0]->batch . ')'; ?></th>
            <th><?php echo @$sub_detials[0]->subject_name; ?></th>
        </tr>

        <tr>
            <th>Student Name</th>
            <th>Average</th>
            <th>Median</th>
        </tr>

        <?php foreach (@$student_details as $details) { ?>
            <tr>
                <td><?php echo $details['name']; ?> </td>
                <td><?php echo $details['average']; ?> </td>
                <td><?php echo $details['median']; ?> </td>
            </tr>
        <?php } ?> 
    </table>
</div>
