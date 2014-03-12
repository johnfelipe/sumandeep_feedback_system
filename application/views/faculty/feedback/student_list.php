<table class="table table-bordered table-striped">
    <tr>
        <th>&nbsp;</th>
        <th>Absent</th>
        <?php foreach ($parameters as $param) { ?>
            <th><?php echo ucwords($param->parameter_name); ?></th>
        <?php } ?>
    </tr>

    <?php foreach ($student_list as $student) { ?>
        <tr>
            <td><?php echo ucwords($student->fullname); ?></td>
            <td><input class="form-control" type="checkbox" name="student_absent[]" value="<?php echo $student->userid; ?>" id="<?php echo 'ratting_' . $student->userid; ?>" onclick="test('<?php echo 'ratting_' . $student->userid; ?>')"/></td>
            <?php foreach ($parameters as $param) { ?>
                <td class="text-center">
                    <div id="<?php echo 'ratting_' . $param->paramterid . '_' . $student->userid; ?>" class="ratting text-center <?php echo 'ratting_' . $student->userid; ?>"></div>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<script type="text/javascript">
    function test(str) {
        if ($('#' + str).is(":checked")) {
            $('.' + str).hide();
            $("." + str + ':input').removeClass('required');
        } else {
            $('.' + str).show();
        }
    }

    $('div.ratting').raty({click: function(score, evt) {
            $("#" + $(this).attr('id') + " :input").attr('name', $(this).attr('id'));
            $("#" + $(this).attr('id') + " :input").removeClass('valid');
            $("#" + $(this).attr('id') + " :input").next().remove();
        }
    });
</script>
