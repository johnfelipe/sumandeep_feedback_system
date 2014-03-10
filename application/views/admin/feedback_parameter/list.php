<script type="text/javascript" >
    $(document).ready(function() {
        $('#list_course').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 25,
            "bSort": false,
            "aoColumns": [
                {"sClass": ""}, {"sClass": "text-center"}, {"sClass": "text-center"}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "feedback_parameter/getJson"; ?>"
        });
    });

    function changeStatus(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var status = '';
        if ($('.parameter-status').html() == '<span class="label label-success">Active</span>') {
            status = 'Deactive';
        } else if ($('.parameter-status').html() == '<span class="label label-danger">Deactive</span>') {
            status = 'Active';
        }

        $.confirm({
            'title': 'Manage Parameter',
            'message': 'Do you Want to ' + status + ' the Parameter ?',
            'buttons': {
                'Yes': {'class': 'btn btn-default',
                    'action': function() {
                        $.ajax({
                            type: 'POST',
                            url: http_host_js + 'feedback_parameter/status/' + current_id,
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

    function changeRole(ele) {
        var current_id = $(ele).attr('id');
        var parent = $(ele).parent().parent();
        var status = '';
        if ($('.parameter-role').html() == 'Student') {
            status = 'Faculty';
        } else if ($('.parameter-role').html() == 'Faculty') {
            status = 'Student';
        }

        $.confirm({
            'title': 'Manage Parameter',
            'message': 'Do you Want to assign this parameter to ' + status + ' ?',
            'buttons': {
                'Yes': {'class': 'btn btn-default',
                    'action': function() {
                        $.ajax({
                            type: 'POST',
                            url: http_host_js + 'feedback_parameter/role/' + current_id,
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
    <h3>Maintain Parameters</h3>
    <hr>
</div>
<div class="col-md-12 add_button">
    <a href="<?php echo ADMIN_URL . 'feedback_parameter/manage'; ?>" class="btn btn-default">
        Add New Parameter
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
    <table id="list_course" class="table table-bordered">
        <thead>
            <tr align="left">
                <th>Parameter Name</th>
                <th width="200">Parameter for</th>
                <th width="75">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
            </tr>
        </tbody>
    </table>
</div>