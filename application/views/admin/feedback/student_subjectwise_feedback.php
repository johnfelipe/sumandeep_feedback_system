<link href="<?php echo CSS_URL; ?>jquery.jqplot.css" rel="stylesheet" />
<div class="col-md-12">
    <h3>
        <?php if (@$label == 'Student Wise') { ?> 
            <a href="<?php echo ADMIN_URL . 'report/feedback/student_subjectwise'; ?>" class="btn btn-primary btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a>
        <?php } else if (@$label == 'Faculty Wise') { ?>
            <a href="<?php echo ADMIN_URL . 'report/feedback/student_facultywise'; ?>" class="btn btn-primary btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Go Back</a>
        <?php } ?>
        &nbsp;
        Feedback Report of Students : <?php echo @$label . @$date_from . @$date_to; ?>
    </h3>
    <hr>
</div>

<?php
if ($this->session->flashdata('error') != '') {
    echo '<div class="col-md-12"><div class="alert alert-danger"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('error') . '</div></div>';
}
?>

<?php
if ($this->session->flashdata('success') != '') {
    echo '<div class="col-md-12"><div class="alert alert-success"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('success') . '</div></div>';
}
?>

<?php
if ($this->session->flashdata('info') != '') {
    echo '<div class="col-md-12"><div class="alert alert-info"><a href="' . current_url() . '" class="close" data-dismiss="alert">&times;</a>' . $this->session->flashdata('info') . '</div></div>';
}
?>

<div class="col-md-12">
    <div id="chart" style="height: 500px;"></div>
</div>

<div class="col-md-12">
    <a type="button" class="btn" style="width:100%;" href="#myModal" data-toggle="modal" data-width="600">Add Image</a>

    <table class="table table-bordered">
        <tr>
            <th><?php echo @$course_detials[0]->course_name; ?></th>
            <th><?php echo @$sem_detials[0]->semester_name . ' (' . @$sem_detials[0]->batch . ')'; ?></th>
            <?php if (isset($sub_detials)) { ?>
                <th><?php echo @$sub_detials[0]->subject_name; ?></th>
            <?php } else if (isset($faculty_detail)) { ?>
                <th><?php echo @$faculty_detail[0]->fullname; ?></th>
            <?php } ?>
        </tr>

        <tr>
            <th>Student Name</th>
            <th>Average</th>
            <th>Median</th>
        </tr>

        <?php
        $name = ',';
        $avg = ',';
        $med = ',';
        foreach (@$student_details as $details) {
            $name .="'" . ucwords($details['name']) . "',";
            $avg .= $details['average'] . ",";
            $med .= $details['median'] . ",";
            ?>
            <tr>
                <td><?php echo $details['name']; ?> </td>
                <th><?php echo $details['average'] == 0 ? '<span class="text-danger">Absent</span>' : $details['average']; ?> </th>
                <th><?php echo $details['median'] == 0 ? '<span class="text-danger">Absent</span>' : $details['median']; ?> </th>
            </tr>
        <?php } ?> 
    </table>
</div>
<script class="code" type="text/javascript">
    $(document).ready(function() {
        var s1 = [<?php echo substr($avg, 1); ?>];
        var s2 = [<?php echo substr($med, 1); ?>];
        var ticks = [<?php echo substr($name, 1); ?>];
        var types = ['Average', 'Median'];

        plot2 = $.jqplot('chart', [s1, s2], {
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            legend: {
                show: true,
                location: 'nw',
                placement: 'inside',
                fontSize: '11px',
                labels: types
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks,
                    label: 'Students',
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
<?php if (count($student_details) > 4) { ?>
                        tickOptions: {
                            angle: - 90
                        }
<?php } ?>
                },
                yaxis: {
                    label: 'Ratting',
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions: {
                        formatString: '%.1f'
                    }
                }
            }
        });

        $(window).resize(function() {
            plot2.replot({resetAxes: true});
        });
        
        createJraphIntoImage();
    });

    function createJraphIntoImage() {
        var imgData = $('#chart').jqplotToImageStr({}); // given the div id of your plot, get the img data
        var imgElem = $('<img class="img-responsive"/>').attr('src', imgData); // create an img and add the data to it
        $('#imgChart').append(imgElem);
    }
</script>
<script class="include" type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jquery.jqplot.js"></script>
<script class="include" type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.barRenderer.js"></script>
<script class="include" type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.categoryAxisRenderer.js"></script>
<script class="include" type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.pointLabels.js"></script>
<script class="include" type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.canvasAxisTickRenderer.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="<?php echo JS_URL; ?>jplot_graph/jqplot.canvasAxisLabelRenderer.js"></script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Feedback Report of Students : <?php echo @$label . @$date_from . @$date_to; ?></h4>
            </div>
            <div class="modal-body" id="imgChart">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->