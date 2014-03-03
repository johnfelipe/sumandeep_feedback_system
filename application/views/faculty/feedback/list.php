<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_course').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 10,
            "aoColumns": [
                {"sClass": ""}, {"sClass": ""}, {"sClass": ""},
                {"sClass": ""}, {"sClass": ""}, {"sClass": ""}
            ],
            "sAjaxSource": "<?php echo FACULTY_URL . "feedback/getJson"; ?>"
        });
    });

</script>
<div class="col-md-12">
    <h3>Maintain Feedback</h3>
    <hr>
</div>
<div class="col-md-12 add_button">
    <a href="<?php echo FACULTY_URL . 'feedback/add'; ?>" class="btn btn-default">
        Add New Feedback
    </a>
</div>
<div class="col-md-12">
    <?php if ($this->session->flashdata('error') != '' || $this->session->flashdata('success') != '') { ?>
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
<?php } ?>
    <table class="display" id="list_course" cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr align="left">
                <th>Student</th>
                <th>Subject</th>
                <th>Topic</th>
                <th>Date</th>
                <th>Time</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
            </tr>
        </tbody>
    </table>
</div>