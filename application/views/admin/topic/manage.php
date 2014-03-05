<script>
    //<![CDATA[
    $(document).ready(function() {
        $("#manage").validate({
        });
    });
    //]]>
</script>
<div class="col-md-12">
    <h3><?php echo (@$topic_detail[0]->topicid != '')? 'Edit ' : 'Add New ';?> Topic for : <?php echo @$subject_detail[0]->subject_name; ?></h3>
    <hr>

    <form action="<?php echo ADMIN_URL . 'topic/mangedata' ?>" method="post" id="manage" class="form-horizontal">
        <input type="hidden" value="<?php echo @$subject_detail[0]->subjectid; ?>" name="subjectid" />
        <input type="hidden" value="<?php echo @$topic_detail[0]->topicid; ?>" name="topicid" />
        <div class="form-group">
            <label for="topic_name" class="col-md-2 control-label">
                Topic Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-md-4">
                <input type="text" name="topic_name" required="required" value="<?php echo @$topic_detail[0]->topic_name; ?>" class="form-control" placeholder="Topic Name"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">&nbsp;</label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="<?php echo ADMIN_URL . 'topic/' . @$subject_detail[0]->subjectid .'/0';  ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>

        <div class="form-group">
            Fields marked with  <span class="text-danger">*</span>  are mandatory.
        </div>
    </form>
</div>