<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_course').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 25,
            "bServerSide" : true,
            "aaSorting": [[0, "desc"]],
            "aoColumns": [
                {"sClass": "text-center", "bSortable": false},
                {"sClass": "", "bSortable": true},
                {"sClass": "", "bSortable": false},
                {"sClass": "", "bSortable": false},
                {"sClass": "text-center", "bSortable": false},
                {"sClass": "text-center", "bSortable": false}
            ],
            "sAjaxSource": "<?php echo STUDENT_URL . "feedback/getJson"; ?>"
        });
    });

</script>
<div class="col-md-12">
    <h3>Maintain Feedback</h3>
    <hr>
</div>
<div class="col-md-12 add_button">
    <a href="<?php echo STUDENT_URL . 'feedback/add'; ?>" class="btn btn-default">
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
    <table class="table table-bordered" id="list_course">
        <thead>
            <tr>
                <th width="125">Date</th>
                <th>Faculty</th>
                <th>Subject</th>
                <th>Topic</th>
                <th width="175">Time</th>
                <th width="125">Result</th>
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