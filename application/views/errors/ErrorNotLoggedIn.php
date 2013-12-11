<form style="background-color: white;">
    <div class="modal-header">
        <center><h4 class="modal-title" id="myModalLabel">Please Login</h4></center>
    </div>
    <div class="modal-body">
        <center><p>Hey there! you need to be logged in before you can ask a question</p>
        <h4><a href="<?php echo site_url('auth/login');?>" class="close-reveal-modal" data-reveal-id="myModal" data-animation="fade">Login</a></h4></center>
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            <button class="btn btn-danger close-reveal-modal ">Close</button>
        </div>
    </div>
</form>