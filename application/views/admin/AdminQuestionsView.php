<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
 
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="<?php echo site_url('../resources/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/bootstrap-dialog.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/datatable-refresh.js') ?>"></script>
<div id="page-wrapper">   
    <div class="row">
        <div class="col-lg-12">
            <h1>Questions <small> Overview</small></h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="active"><i class="fa fa-bar-chart-o"></i> Questions</li>
            </ol>
        </div>
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>All Questions</h4>
            <hr>
            <table id="qTable">
            </table>
        </div>
    </div>
    <hr>
    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Error</h4>
                </div>
                <div class="modal-body" id="errModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript">

    $(document).ready(function() {
        initQuestTable();
    });

    function initQuestTable() {
        $('#qTable').dataTable({
            "sAjaxSource": '/MobileHub/index.php/api/admin/question/details',
            "sServerMethod": "POST",
            "aoColumns": [{
                    "mData": "questionId",
                    "sTitle": "Id"
                }, {
                    "mData": "questionTitle",
                    "sTitle": "Question Title",
                    "mRender": function(url, type, row) {
                        return  '<a href="/MobileHub/index.php/questions/show/?id=' + row['questionId'] + '">' + url + '</a>';
                    }
                }, {
                    "mData": "askedOn",
                    "sTitle": "Asked On"
                }, {
                    "mData": "askerName",
                    "sTitle": "Asked By",
                    "mRender": function(url, type, full) {
                        return  '<a href="/MobileHub/index.php/profile/?user=' + url + '">' + url + '</a>';
                    }
                }, {
                    "mData": "answerCount",
                    "sTitle": "Answers"
                }, {
                    "mData": "votes",
                    "sTitle": "Votes"
                }, {
                    "sTitle": "Action",
                    "mData": "votes",
                    "bSortable": false,
                    "sClass": "center",
                    "mRender": function(url, type, row) {
                        return  '<a href="javascript: deleteAnswer(' + row['questionId'] + ');" class="btn btn-sm btn-danger" title="Delete Question"><i class="btn-icon-only glyphicon glyphicon-trash"></i></a>';
                    }
                }]
        });
    }
    function deleteAnswer(qId) {
        BootstrapDialog.confirm('Are you sure you want to delete this question?', function(result) {
            if (result) {
                jsonData = {'username': "<?php echo $name; ?>", "questionId": qId};
                $.post("/MobileHub/index.php/api/question/delete/", jsonData, function(content) {

                    // Deserialise the JSON
                    content = jQuery.parseJSON(content);
                    if (content.message === "Success") {
                        $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                        $('#errorModal').modal('show');
                        var dt = $('#qTable').dataTable();
                        dt.fnReloadAjax();
                        return true;
                    } else {
                        $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                        $('#errorModal').modal('show');
                    }
                }).fail(function() {
                    $('#errModalBody').html("<p><center>" + "Something went wrong when updating. Please try again later" + "</center></p>");
                    $('#errorModal').modal('show');
                }), "json";
                return true;
            } else {
                // Do nothing
            }
        });
    }
</script>