<script src="<?php echo site_url('../resources/js/bootstrap-dialog.js') ?>"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Wait Up!</h1>
                <h2>You are requesting the site administrator to permanently deactivate your profile</h2>
                <div class="error-details">
                    Are you sure you want to deactivate your profile?
                </div>
                <div class="error-actions">
                    <a href="javascript: goBack()" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-arrow-left"></span>
                        Go back </a><a href="javascript: deactivate()" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-trash"></span> Deactivate profile </a>
                </div>
            </div>
        </div>
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

<!-- Modal -->
<div class="modal fade" id="pwordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Please enter your password to proceed</h4>
            </div>
            <div class="modal-body">
                <input type="password" id="pwordBox" style="width: 100%"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="sendRequest();">Okay</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Error</h4>
            </div>
            <div class="modal-body" id="succModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
                    function goBack() {
                        window.history.back();
                    }

                    function reload() {
                        window.location = "/MobileHub/";
                    }

                    function sendRequest() {
                        $pword = $("#pwordBox").val();

                        jsonData = {'username': "<?php echo $user ?>", 'pword': $pword};

                        $.post("/MobileHub/index.php/api/user/delete/", jsonData, function(content) {

                            // Deserialise the JSON
                            content = jQuery.parseJSON(content);
                            if (content.message === "Success") {
                                $('#succModalBody').html("<p><center>" + content.type + "</center></p>");
                                $('#successModal').modal('show');
                            } else {
                                $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                $('#errorModal').modal('show');
                            }
                        }).fail(function() {
                            $('#errModalBody').html("<p><center>" + "Something went wrong when updating. Please try again later" + "</center></p>");
                            $('#errorModal').modal('show');
                        }), "json";
                        return true;
                    }

                    function deactivate() {
                        $('#pwordModal').modal('show');
                    }
</script>