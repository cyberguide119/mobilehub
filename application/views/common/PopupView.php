<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
<div id="myModal" class="reveal-modal">
    <?php $this->load->view($subview); // Subview is set in controller ?>
</div>

<script src="https://code.jquery.com/jquery.js"></script>
<script src="<?php echo site_url('../resources/js/bootstrap.min.js')?>"></script>
<script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
<script type="text/javascript">
/* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
        modules : 'date, security',
        onSuccess : function() {
            $.post("/MobileHub/index.php/auth/authenticate", function (content) {
                  $("#myModal").html(content);
                });
            //alert('The form is valid!');
            return true;
        }
    });
</script>
