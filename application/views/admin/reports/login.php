<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();

        $("#userid").change(function() {
            loadDatatable();
        });

<?php $date = date('m/d/Y', strtotime(get_current_date_time()->get_date_for_db())); ?>
        $("#date_from").datepicker({dateFormat: 'dd-mm-yy', maxDate:<?php echo $date; ?>, changeMonth: true, changeYear: true, yearRange: "1900:<?php echo date('Y'); ?>"});

        $("#date_to").datepicker({dateFormat: 'dd-mm-yy', maxDate:<?php echo $date; ?>, changeMonth: true, changeYear: true, yearRange: "1900:<?php echo date('Y'); ?>"});


        $("#date_to").change(function() {
            loadDatatable();
        });

    });



    function loadDatatable() {
        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
        }

        var userid = $('#userid').val();
        var date_from = $('#date_from').val()
        var date_to = $('#date_to').val();

        if (date_from === '' || date_from === undefined) {
            date_from = 'null';
        }

        if (date_to === '' || date_to === undefined) {
            date_to = 'null';
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
                {"sClass": "text-center", "bSortable": false},
                {"sClass": "text-center", "bSortable": false},
                {"sClass": "text-center", "bSortable": false}
            ],
            "sAjaxSource": "<?php echo ADMIN_URL . "report/login/getJson/" . $role . '/'; ?>" + userid + '/' + date_from + '/' + date_to
        });
    }

</script>
<div class="col-md-12">
    <h3>Login Report of (<?php echo ($role == 'S' ? 'Student' : 'Faculty') ?>)</h3>
    <hr>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            <select class="form-control" name="userid" id="userid">
                <option value="null">Select <?php echo ($role == 'S' ? 'Student' : 'Faculty') ?></option>
                <?php foreach ($user_details as $user) { ?>
                    <option value="<?php echo $user->userid; ?>"><?php echo $user->fullname; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="date_from" id="date_from" placeholder="Date From" class="form-control" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db() . '-1 day')); ?>"/>
        </div>
        <div class="col-md-4">
            <input type="text" id="date_to" name="date_to" class="form-control" placeholder="Date To" value="<?php echo date('d-m-Y', strtotime(get_current_date_time()->get_date_for_db(). '-1 day')); ?>"/>
        </div>
    </div>
</div>
<br />
<div class="col-md-12">
    <table class="table table-bordered" id="list_login_log">
        <thead>
            <tr>
                <th>Name</th>
                <th width="150">Total Login</th>
                <th width="150">Date</th>
                <th width="150">Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
                <td>etc</td>
            </tr>
        </tbody>
    </table>
</div>