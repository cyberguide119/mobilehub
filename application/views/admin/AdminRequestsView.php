<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="<?php echo site_url('../resources/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/bootstrap-dialog.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/datatable-refresh.js') ?>"></script>
<div id="page-wrapper">   
    <div class="row">
        <div class="col-lg-12">
            <h1>Requests <small> Overview</small></h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="active"><i class="fa fa-flag"></i> Requests</li>
            </ol>
        </div>
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>New Tutor Registrations</h4><hr>
            <table id="qTable">
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <h4>Account Removal Requests</h4><hr>
            <table id="qTable2">
            </table>
        </div>
    </div>
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
        initQuestTable2();
    });

    function initQuestTable() {
        $('#qTable').dataTable({
            "sAjaxSource": '/MobileHub/index.php/api/admin/requests/tutor',
            "sServerMethod": "POST",
            "aoColumns": [{
                    "mData": "requestId",
                    "sTitle": "Id"
                }, {
                    "mData": "userId",
                    "sTitle": "User Id"
                }, {
                    "mData": "rDate",
                    "sTitle": "Registered On"
                }, {
                    "mData": "username",
                    "sTitle": "Username",
                    "mRender": function(url, type, row) {
                        return  '<a href="/MobileHub/index.php/profile/?user=' + row['username'] + '">' + url + '</a>';
                    }
                }, {
                    "mData": "email",
                    "sTitle": "Email"
                }, {
                    "sTitle": "Action",
                    "mData": "email",
                    "bSortable": false,
                    "sClass": "center",
                    "mRender": function(url, type, row) {
                        return  '<a href="javascript: acceptTutor(' + row['requestId'] + "," + row['userId'] + ');" class="btn btn-sm btn-success" title="Delete Question"><i class="btn-icon-only glyphicon glyphicon-ok"></i></a>&nbsp'
                                + '<a href="javascript: declineTutor(' + row['requestId'] + "," + row['userId'] + ');" class="btn btn-sm btn-danger" title="Delete Question"><i class="btn-icon-only glyphicon glyphicon-remove"></i></a>';
                    }
                }]
        });
    }
    
    function initQuestTable2() {
        $('#qTable2').dataTable({
            "sAjaxSource": '/MobileHub/index.php/api/admin/requests/delete',
            "sServerMethod": "POST",
            "aoColumns": [{
                    "mData": "requestId",
                    "sTitle": "Id"
                }, {
                    "mData": "userId",
                    "sTitle": "User Id"
                }, {
                    "mData": "rDate",
                    "sTitle": "Registered On"
                }, {
                    "mData": "username",
                    "sTitle": "Username",
                    "mRender": function(url, type, row) {
                        return  '<a href="/MobileHub/index.php/profile/?user=' + row['username'] + '">' + url + '</a>';
                    }
                }, {
                    "mData": "email",
                    "sTitle": "Email"
                }, {
                    "sTitle": "Action",
                    "mData": "email",
                    "bSortable": false,
                    "sClass": "center",
                    "mRender": function(url, type, row) {
                        return  '<a href="javascript: removeAccount(' + row['requestId'] + "," + row['userId'] + ');" class="btn btn-sm btn-danger" title="Delete Question"><i class="btn-icon-only glyphicon glyphicon-remove"></i></a>';
                    }
                }]
        });
    }
    
    function acceptTutor(qId, tutorId) {
        BootstrapDialog.confirm('Are you sure you want to accept this tutor?', function(result) {
            if (result) {
                jsonData = {'username': "<?php echo $name; ?>", "rId": qId, "tutorId": tutorId};
                $.post("/MobileHub/index.php/api/admin/tutor/accept/", jsonData, function(content) {

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

    function declineTutor(qId, tutorId) {
        BootstrapDialog.confirm('Are you sure you want to decline this tutor request?', function(result) {
            if (result) {
                jsonData = {'username': "<?php echo $name; ?>", "rId": qId, "tutorId": tutorId};
                $.post("/MobileHub/index.php/api/admin/tutor/decline/", jsonData, function(content) {

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
    
    function removeAccount(qId, tutorId) {
        BootstrapDialog.confirm('Are you sure you want to remove this account?', function(result) {
            if (result) {
                jsonData = {'username': "<?php echo $name; ?>", "rId": qId, "userId": tutorId};
                $.post("/MobileHub/index.php/api/admin/deletion/accept", jsonData, function(content) {

                    // Deserialise the JSON
                    content = jQuery.parseJSON(content);
                    if (content.message === "Success") {
                        $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                        $('#errorModal').modal('show');
                        var dt = $('#qTable2').dataTable();
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