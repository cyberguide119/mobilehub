<div class="container askForm">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <span class="glyphicon glyphicon-file">
                        </span>EDIT QUESTION
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Title" required id="qTitle" maxlength="100" data-provide="typeahead"/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Describe your problem here" rows="5" required id="qDesc" maxlength="600"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tags">
                                    Tags</label>
                                <a href="#" id="helpText" data-toggle="popover" title="" data-content="You can create tags either by pressing enter after each tag or by using commas to separate the tags. Eg : android, java, help" role="button" data-original-title="Quick Tip">(Help)</a>
                                <br>
                                <input type="text" data-role="tagsinput" class="form-control" id="qTags" data-provide="typeahead" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">
                                    Category</label>
                                <select class="form-control" id="qCategory">
                                    <?php foreach ($categories as $cate): ?>
                                        <option><?php echo $cate->categoryName ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button onclick="updateQuestion();" class="btn btn-success btn-mg"><span class="glyphicon glyphicon-floppy-disk">
                                </span>Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="qError"></div>
</div>

<script type="text/javascript">
                                $(document).ready(function() {
                                    $.get("/MobileHub/index.php/api/question/details/" + "<?php echo $questionId ?>", function(resultsData) {
                                        resultsData = jQuery.parseJSON(resultsData);
                                        if (resultsData.message === "Error") {
                                            window.location = "/MobileHub/index.php/custom404/";
                                            return false;
                                        } else {
                                            var userViewing = "<?php echo $name ?>";
                                            if (userViewing === resultsData.questionDetails.askerName) {
                                                loadUI(resultsData.questionDetails);
                                                return true;
                                            } else {
                                                window.location = "/MobileHub/index.php/custom403/";
                                                return false;
                                            }
                                        }
                                    });
                                });

                                $(function() {
                                    jsonTags = new Array();

                                    $.get("/MobileHub/index.php/api/tags/all", function(resultsData) {
                                        resultsData = jQuery.parseJSON(resultsData);
                                        jsonTags = resultsData;
                                        var newArr = new Array();

                                        for (x in jsonTags) {
                                            newArr.push(jsonTags[x].tagName);
                                        }
                                        $('.bootstrap-tagsinput input[type=text]').attr("placeholder", " ");
                                        $('.bootstrap-tagsinput input[type=text]').attr("data-provide", "typeahead");
                                        $('.bootstrap-tagsinput input[type=text]').typeahead({source: newArr});
                                        return true;
                                    });
                                });

                                $(function() {
                                    $('#helpText').popover();
                                });

                                $('#qDesc').maxlength({
                                    alwaysShow: true
                                });

                                $('#qTitle').maxlength({
                                    alwaysShow: true
                                });

                                function loadUI(resultsData) {
                                    $("#qTitle").val(resultsData.questionTitle);
                                    $("#qDesc").val(resultsData.questionDescription.replace(/\<br \/>/g, ''));
                                    setTags(resultsData.tags);
                                    $("#qCategory").val(resultsData.category);
                                }

                                function setTags(tags) {
                                    var lastElement = 0;
                                    var tagStr = "";
                                    for (var i = 0; i < tags.length; i++) {
                                        if (lastElement === tags.length - 1) {
                                            tagStr += tags[i];
                                            //break;
                                        } else {
                                            tagStr += tags[i] + ",";
                                        }
                                        lastElement++;
                                    }
                                    $('.bootstrap-tagsinput input[type=text]').val(tagStr);
                                    var e = jQuery.Event("keydown");
                                    e.which = 13; //choose the one you want
                                    e.keyCode = 13;
                                    $('.bootstrap-tagsinput input[type=text]').trigger(e);
                                }

                                function updateQuestion()
                                {
                                    $qTitle = $("#qTitle").val();
                                    $qDesc = $("#qDesc").val();
                                    $qTags = checkTags($("#qTags").val());
                                    $qCategory = (($("#qCategory")[0]).selectedIndex) + 1;
                                    $qAskerName = "<?php echo $name ?>";

                                    $jsonObj = {"Title": $qTitle, "Description": $qDesc, "Tags": $qTags, "Category": $qCategory, "AskerName": $qAskerName, "questionId": "<?php echo $questionId ?>"};

                                    if (valdateForm($qTitle, $qDesc, $qTags, $qCategory)) {
                                        $.post("/MobileHub/index.php/api/question/update", $jsonObj, function(content) {

                                            // Deserialise the JSON
                                            content = jQuery.parseJSON(content);
                                            if (content.message === "Success") {
                                                $("#qError").removeClass('alert alert-danger');
                                                $("#qError").addClass('alert alert-success');
                                                $("#qError").text('Question updated successfully!');
                                                //window.location.href = "/MobileHub/index.php/";
                                            } else {
                                                $("#qError").addClass('alert alert-danger');
                                                $("#qError").text('Sorry, something went wrong when posting the question! Please try again');
                                            }
                                        }).fail(function() {
                                            $("#qError").addClass('alert alert-danger');
                                            $("#qError").text('Sorry, something went wrong when posting the question! Please try again');

                                        }), "json";
                                        return true;
                                    }

                                    function checkTags($tags) {
                                        return $tags;
                                    }

                                    function valdateForm($qTitle, $qDesc, $qTags, $qCategory) {
                                        var errors = new Array();
                                        var errorStr = "";
                                        if ($qTitle === '' || $qDesc === '' || $qTags === '' || $qCategory === '') {
                                            errors.push("You need to fill all the sections");
                                        }

                                        if (($qTags.split(',')).length > 4) {
                                            errors.push("You can have only a maximum of 4 tags");
                                        }

                                        if (errors.length > 0) {
                                            for (x in errors) {
                                                errorStr += errors[x] + "\n\n";
                                            }
                                            $("#qError").addClass('alert alert-danger');
                                            $("#qError").text(errorStr);
                                            return false;
                                        }
                                        return true;
                                    }
                                }
</script>