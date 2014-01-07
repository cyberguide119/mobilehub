<script src="<?php echo site_url('../resources/js/jquery.bootpag.min.js') ?>"></script>
<script type="text/javascript">
    function getTagsString($tags)
    {
        var str = "";
        for (var i = 0; i < $tags.length; i++) {
            str += "<a href='/MobileHub/index.php/tags/show/" + $tags[i].replace(/ /g, '+') + "'><button type='button' class='btn btn-info btn-xs' title='tag' text='Category'>" + $tags[i] + "</button></a>&nbsp";
        }
        return str;
    }

    function advSearch(offset, page) {
        $advWords = $("#advWords").val();
        $advPhrase = $("#advPhrase").val();
        $advTags = sanitizeTags($('.bootstrap-tagsinput').val());
        $advCategory = (($("#advCategory")[0]).selectedIndex);

        $jsonObj = {"Words": $advWords, "Phrase": $advPhrase, "Tags": $advTags, "Category": $advCategory, "Offset": offset};

        $.post("/MobileHub/index.php/api/search/questions/advanced", $jsonObj, function(content) {
            // Deserialise the JSON
            content = jQuery.parseJSON(content);
            loadUI(content, "adv", page);
        }).fail(function() {
            $("#qError").addClass('alert alert-danger');
            $("#qError").text('Sorry, something went wrong when posting the question! Please try again');

        }), "json";
        return true;
    }

    function sanitizeTags(tags) {
        var str = '';
        var cnt = 0;
        for (tag in tags) {
            if (cnt !== tags.length - 1) {
                str += tags[tag] + ',';
            } else {
                str += tags[tag];
            }
            cnt++;
        }
        //str = str[str.length -1]
        return str;
    }
</script>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="/MobileHub/index.php">Home</a></li>
        <li class="active">Search Results</li>
    </ol>
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
                        <input type="text" data-role="tagsinput" class="form-control" data-provide="typeahead" class="form-control" placeholder="Containing the tags" id="advTags" style="line-height: 22px;">
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
                            <button class="btn btn-success btn-mg" id="btnSearch" onclick="advSearch(0, 1);"><span class="glyphicon glyphicon-search">
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
    <div id="page-selection" style="width: 20%;  margin: 0 auto;"></div>

</div>
<script type="text/javascript">
    // Move this to a separate file and load it here.
    $(document).ready(function() {
        $("#advPhrase").val("<?php echo $results ?>");
        $("#search-term").val("<?php echo $results ?>");
        $.get("/MobileHub/index.php/api/search/questions?query=" + "<?php echo $results ?>", function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            loadUI(resultsData, "basic", 1);
            return true;
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
            $('.bootstrap-tagsinput input[type=text]').attr("placeholder", "Containing tags");
            $('.bootstrap-tagsinput input[type=text]').attr("style", "height: 33px; width: 112px !important");
            $('.bootstrap-tagsinput input[type=text]').attr("data-provide", "typeahead");
            $('.bootstrap-tagsinput input[type=text]').attr("id", "advTags");
            $('.bootstrap-tagsinput input[type=text]').typeahead({source: newArr});
            return true;
        });

        $('.bootstrap-tagsinput').tagsinput({
            maxTags: 4
        });
    });

    function loadUI(resultsData, option, page) {
        if (resultsData.message === "Error") {
            $("ul.list-group").html("<h5><b>0</b> result(s) found</h5><p>" + resultsData.type + "</p>");
        } else {
            $("ul.list-group").html("<h5><b>" + resultsData.results.length + "</b> result(s) found</h5>");
            for (var i = 0; i < resultsData.results.length; i++) {
                var result = resultsData.results[i];
                dateAsked = result.askedOn.split(' ');
                var listItem = "<li class='list-group-item' style='margin-bottom: 5px;'>"
                        + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                        + "<img src='/MobileHub/resources/img/default.png' class='img-circle img-responsive' alt='' /></div>"
                        + "<div class='col-xs-10 col-md-9' style='width: 68%;'><div>"
                        + "<a href='questions/show/?id=" + result.questionId + "'>" + result.questionTitle + "</a>"
                        + "<div class='mic-info'> Asked by <a href='/MobileHub/index.php/profile/?user=" + result.askerName + "'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
                        + "<div class='comment-text'><br>"
                        + refineDescription(result.questionDescription) + "</div>"
                        + "<div class='action'>"
                        + getTagsString(result.tags)
                        + "</div></div>" //tags
                        + "<div class='col-md-2' style='width: 18%;'><div class='vote-box' title='Votes'><span class='vote-count'>"
                        + result.votes + "</span><span class='vote-label'>votes</span></div>"
                        + "<div class='ans-count-box' title='Answers'><span class='ans-count'>"
                        + result.answerCount + "</span>"
                        + "<span class='ans-label'>answers</span></div></div></div></li>";
                $("ul.list-group")
                        .append(listItem);
                $('#page-selection').unbind();
                setupPagination(resultsData.totalCount, option, page);
            }
        }
    }

    function setupPagination(totalCount, option, currentPage) {
        $('#page-selection').bootpag({
            total: totalCount,
            page: currentPage,
            maxVisible: 10
        }).on('page', function(event, num) {
            changePage(option, ((num * 10) - 10));
            return;
        });
    }

    function changePage(option, $offset, page) {

        if (option === 'basic') {
            $.get("/MobileHub/index.php/api/search/questions?query=" + "<?php echo $results ?>" + "&page=" + $offset, function(resultsData) {
                resultsData = jQuery.parseJSON(resultsData);
                loadUI(resultsData, option, page);
                return true;
            });
        } else {
            advSearch($offset, page);
        }
    }

    function refineDescription(desc) {
        if (desc.length > 150) {
            desc = desc.substring(0, 150) + " ...";
        }
        return desc;
    }

    $('.form-control').keypress(function(e) {
        if (e.which === 13) {
            advSearch(0);
        }
    });
</script>