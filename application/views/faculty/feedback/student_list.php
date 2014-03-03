<table class="table table-bordered table-striped">
    <tr>
        <th>&nbsp;</th>
        <?php foreach ($parameters as $param) { ?>
            <th><?php echo ucwords($param->parameter_name); ?></th>
        <?php } ?>
    </tr>

    <?php foreach ($student_list as $student) { ?>
        <tr>
            <td><?php echo ucwords($student->fullname); ?></td>
            <?php foreach ($parameters as $param) { ?>
                <td class="text-center">
                    <div id="<?php echo 'ratting_' . $param->paramterid . '_' . $student->userid; ?>" class="ratting text-center"></div>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<script>
    $('div.ratting').raty({score: 1, click: function(score, evt) {
            $("#" + $(this).attr('id') + " :input").attr('name', $(this).attr('id'));
        }
    });
</script>
