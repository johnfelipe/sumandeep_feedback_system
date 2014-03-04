<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_course').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 10,
            "bSort": false,
            "aoColumns": [
                {"sClass": ""}, {"sClass": ""}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "student/getJson"; ?>"
        });
    });

    function deleteRow(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var status = '';
        if($('.student-status').html() == '<span class="label label-success">Active</span>'){
            status = 'Deactive';
        }else if($('.student-status').html() == '<span class="label label-danger">Deactive</span>'){
            status = 'Active';
        }
        
        $.confirm({
            'title': 'Manage Sutdent',
            'message': 'Do you Want to '+ status + ' the Sutdent ?',
            'buttons': {
                'Yes': {'class': 'btn btn-default',
                    'action': function() {
                        $.ajax({
                            type: 'POST',
                            url: http_host_js + 'student/delete/' + current_id,
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
    <h3>Maintain Student</h3>
    <hr>
</div>
<div class="col-md-12 add_button">
    <a href="<?php echo ADMIN_URL . 'student/manage'; ?>" class="btn btn-default">
        Add New Student
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
            <tr align="left">
                <th>Student Name</th>
                <th width="25">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <td>etc</td>
            </tr>
        </tbody>
    </table>
</div>