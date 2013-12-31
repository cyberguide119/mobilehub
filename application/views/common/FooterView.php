<script type="text/javascript">
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    function search() {
        var searchQuery = $("#search-term").val();
        if (searchQuery.length < 3) {
            $('#search-term').popover('show');
        } else {
            searchQuery = searchQuery.replace(/ /g, '+');
            window.location.href = '/MobileHub/index.php/search?query=' + searchQuery;
        }
    }

    $.validate({
        modules: 'date, security',
        onSuccess: function() {
            $dataToSend = new Array();
            $loginForm = $("#loginForm");
            $serializedData = $loginForm.serializeArray();
            $tmpObj1 = $serializedData[0];
            $tmpObj2 = $serializedData[0];
            if (!($tmpObj1.value === '' || $tmpObj2.value === '')) {
                $.post("/MobileHub/index.php/api/auth/login", $serializedData, function(content) {

                    // Deserialise the JSON
                    content = jQuery.parseJSON(content);
                    if (content.message === "correct") {
                        $("#error").removeClass('alert alert-danger');
                        $("#error").addClass('alert alert-success');
                        $("#error").text('Login successful!');
                        location.reload();
                    } else {
                        $("#error").addClass('alert alert-danger');
                        $("#error").text('Sorry, your login credentials are incorrect! Please try again');
                    }
                }), "json";
                return true;
            }
        }
    });
    function resetForm() {
        $("#error").removeClass('alert alert-danger');
        $("#error").text('');
    }

    function sendLink() {
        
        $email = $("#txtResetEmail").val();
        if (checkEmail($email)) {
            
            jsonObj = {'email': $email};
            $.post("/MobileHub/index.php/api/auth/forgot", jsonObj, function(resultsData) {
                resultsData = jQuery.parseJSON(resultsData);
                if (resultsData.message === "Success") {
                     alert("success");
                }
                return true;
            }).fail(function() {
                alert("error");
            });
        }
    }

    function checkEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

</script>
<hr>
<footer>
    <p style="text-align: center">&copy; Created by Sahan Serasinghe | 2013</p>
</footer>
<script src="<?php echo site_url('../resources/js/bootstrap.min.js') ?>"></script>
</body>
</html>
