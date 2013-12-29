<script type="text/javascript">
    function getTagsString($tags)
    {
        var str = "";
        for (var i = 0; i < $tags.length; i++) {
            str += "<button type='button' class='btn btn-info btn-xs' title='Approved' text='Category'>" + $tags[i] + "</button>&nbsp";
        }
        return str;
    }

    function advSearch() {
        $advWords = $("#advWords").val();
        $advPhrase = $("#advPhrase").val();
        $advTags = $("#advTags").val();
        $advCategory = (($("#advCategory")[0]).selectedIndex);

        $jsonObj = {"Words": $advWords, "Phrase": $advPhrase, "Tags": $advTags, "Category": $advCategory};

        $.post("/MobileHub/index.php/api/search/questions/advanced", $jsonObj, function(content) {

            // Deserialise the JSON
            content = jQuery.parseJSON(content);
            loadUI(content);
        }).fail(function() {
            $("#qError").addClass('alert alert-danger');
            $("#qError").text('Sorry, something went wrong when posting the question! Please try again');

        }), "json";
        return true;
    }
</script>
<div class="container">
    <div class="panel-body" id="accordion">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="color: white; text-decoration: none;">
                    Click here for Advanced Search <b class="caret"></b>
                </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" placeholder="Containing the phrase" id="advPhrase">
                        <br>
                        <input type="text" class="form-control" placeholder="Containing the tags" id="advTags">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" placeholder="Containing any of the words" id="advWords">
                        <br>
                        <div class="col-xs-9" style="margin-left: -14px;">
                            <select class="form-control" id="advCategory">
                                <option>All Categories</option>
                                <?php foreach ($categories as $cate): ?>
                                    <option><?php echo $cate->categoryName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <button class="btn btn-success btn-mg" id="btnSearch" onclick="advSearch();"><span class="glyphicon glyphicon-search">
                                </span>Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Search Results</h4>
        <ul class="list-group">
        </ul>
    </div>

</div>
<script type="text/javascript">
    // Move this to a separate file and load it here.
    $(document).ready(function() {
        $("#advPhrase").val("<?php echo $results ?>");
        $.get("/MobileHub/index.php/api/search/questions?query=" + "<?php echo $results ?>", function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            loadUI(resultsData);
            return true;
        });
    });

    function loadUI(resultsData) {
        if (resultsData.results === "No results found") {
            $("ul.list-group").html("<h5><b>0</b> result(s) found</h5><p>Sorry, your query returned no matches!</p>");
        } else {
            $("ul.list-group").html("<h5><b>" + resultsData.results.length + "</b> result(s) found</h5>");
            for (var i = 0; i < resultsData.results.length; i++) {
                var result = resultsData.results[i];
                dateAsked = result.askedOn.split(' ');
                var listItem = "<li class='list-group-item' style='margin-bottom: 5px;'>"
                        + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                        + "<img src='/MobileHub/resources/img/default.png' class='img-circle img-responsive' alt='' /></div>"
                        + "<div class='col-xs-10 col-md-9'><div>"
                        + "<a href='question/show/?id="+result.questionId+"'>" + result.questionTitle + "</a>"
                        + "<div class='mic-info'> Asked by <a href='/MobileHub/index.php/profile/?user="+result.askerName+"'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
                        + "<div class='comment-text'><br>"
                        + refineDescription(result.questionDescription) + "</div>"
                        + "<div class='action'>"
                        + getTagsString(result.tags)
                        + "</div></div>" //tags
                        + "<div class='col-md-2'><div class='vote-box' title='Votes'><span class='vote-count'>"
                        + result.votes + "</span><span class='vote-label'>votes</span></div>"
                        + "<div class='ans-count-box' title='Answers'><span class='ans-count'>"
                        + result.answerCount + "</span>"
                        + "<span class='ans-label'>answers</span></div></div></div></li>";
                $("ul.list-group")
                        .append(listItem);
            }
        }
    }
    
    function refineDescription(desc){
        if(desc.length > 150){
            desc = desc.substring(0,150) + " ...";
        }
        return desc;
    }
</script>