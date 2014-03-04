<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_semester').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 10,
            "bSort": false,
            "aoColumns": [
                {"sClass": ""}, {"sClass": "text-center"}, {"sClass": "text-center"}, {"sClass": "text-center"}, {"sClass": ""}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "semester/getJson/" . @$course_detail[0]->cid; ?>"
        });
    });

    function deleteRow(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        $.confirm({
            'title': 'Delete Semester',
            'message': 'Do you Want to Delete ?',
            'buttons': {
                'Yes': {'class': 'btn btn-default',
                    'action': function() {
                        $.ajax({
                            type: 'POST',
                            url: http_host_js + 'semester/delete/' + current_id,
                            data: id = current_id,
                            beforeSend: function() {
                                parent.animate({'backgroundColor': '#fb6c6c'}, 500);
                            },
                            success: function() {
                                window.location.reload();
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('error');
                            }
                        });
                    }
                },
                'No': {
                    'class': 'btn btn-default',
                    'action': function() {
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
        return false;
    }
</script>
<div class="col-md-12">
    <h3>Maintain Semester for : <?php echo @$course_detail[0]->course_name; ?></h3>
    <hr>
</div>
<div class="col-md-12 add_button">
    <a href="<?php echo ADMIN_URL . 'semester/manage/' . @$course_detail[0]->cid; ?>" class="btn btn-default">
        Add New Semester
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
    <table id="list_semester" class="table table-bordered">
        <thead>
            <tr align="left">
                <th>Semester Name</th>
                <th width="100">Batch</th>
                <th width="200">Subject</th>
                <th width="200">Assign Faculty</th>
                <th width="25">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
            </tr>
        </tbody>
    </table>
</div>