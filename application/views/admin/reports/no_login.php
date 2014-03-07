<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        $("#userid").change(function() {
            loadDatatable();
        });

<?php $date = date('m/d/Y', strtotime(get_current_date_time()->get_date_for_db())); ?>
        $("#date_from").datepicker({dateFormat: 'dd-mm-yy', maxDate:<?php echo $date; ?>, changeMonth: true, changeYear: true, yearRange: "1900:<?php echo date('Y'); ?>"});


        $("#date_from").change(function() {
            loadDatatable();
        });

    });



    function loadDatatable() {
        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
        }

        var userid = $('#userid').val();
        var date_from = $('#date_from').val()

        if (date_from === '' || date_from === undefined) {
            date_from = 'null';
        }

        dTable = $('#list_login_log').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            'iDisplayLength': 50,
            "bServerSide": true,
            "bFilter": false,
            "aaSorting": [[0, "desc"]],
            "aoColumns": [
                {"sClass": "", "bSortable": true},
<?php if ($role == 'S') { ?>
                    {"sClass": "text-center", "bSortable": false},
                    {"sClass": "text-center", "bSortable": false},
<?php } ?>
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "report/login/getJsonForNoLogin/" . $role . '/'; ?>" + userid + '/' + date_from
        });
    }

</script>
<div class="col-md-12">
    <h3>No Login Report of (<?php echo ($role == 'S' ? 'Student' : 'Faculty') ?>)</h3>
    <hr>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <select class="form-control" name="userid" id="userid">
                <option value="null">Select <?php echo ($role == 'S' ? 'Student' : 'Faculty') ?></option>
                <?php foreach ($user_details as $user) { ?>
                    <option value="<?php echo $user->userid; ?>"><?php echo $user->fullname; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" name="date_from" id="date_from" placeholder="Date From" class="form-control" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db())); ?>"/>
        </div>
    </div>
</div>
<br />
<div class="col-md-12">
    <table class="table table-bordered" id="list_login_log">
        <thead>
            <tr>
                <th>Name</th>
                <?php if ($role == 'S') { ?>
                    <th width="200">Semester</th>
                    <th width="200">Course</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <?php if ($role == 'S') { ?>
                    <td>etc</td>
                    <td>etc</td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>