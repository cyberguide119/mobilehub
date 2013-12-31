<script src="<?php echo site_url('../resources/js/jquery.bootpag.min.js') ?>"></script>
<div class="container">
    <div>
        <h4>Questions tagged with <span id="tagName" class="label label-info">Default</span></h4>
        <br>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active" onclick="changeTab('recent', 0);"><a href="#home" data-toggle="tab">Recent</a></li>
            <li class="" onclick="changeTab('popular', 0);"><a href="#profile" data-toggle="tab">Popular</a></li>
            <li class="" onclick="changeTab('unanswered', 0);"><a href="#profile" data-toggle="tab">Unanswered</a></li>
            <li class="" onclick="changeTab('all', 0);"><a href="#profile" data-toggle="tab">All</a></li>
        </ul>
        <div class="panel-body">
            <div class="tab-content">
                <ul class="list-group">
                </ul>
            </div>
            <div id="page-selection" style="width: 20%;  margin: 0 auto;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">

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

                function changePage(option, $offset) {
                    console.log(option);

                    $.get("/MobileHub/index.php/api/question/" + option + "/" + $offset, function(resultsData) {
                        resultsData = jQuery.parseJSON(resultsData);
                        loadUI(resultsData);
                        return true;
                    });
                }

                function changeTab(option, $offset) {
                    $.get("/MobileHub/index.php/api/question/" + option + "/" + $offset, function(resultsData) {
                        resultsData = jQuery.parseJSON(resultsData);
                        loadUI(resultsData);
                        $('#page-selection').unbind();
                        setupPagination(resultsData.totalCount, option, 1);
                        return true;
                    });
                }

                function getTagsString($tags)
                {
                    var str = "";
                    for (var i = 0; i < $tags.length; i++) {
                        str += "<button type='button' class='btn btn-info btn-xs' title='Approved' text='Category'>" + $tags[i] + "</button>&nbsp";
                    }
                    return str;
                }

                $(document).ready(function() {
                    changeTab('recent', 0);
                });

                function loadUI(resultsData) {
                    if (resultsData.results.length === 0) {
                        $("ul.list-group").html("<h4><center>No questions available. Why don't you ask one? :)</center></h4>");
                        return;
                    }

                    $("ul.list-group")
                            .html('');
                    for (var i = 0; i < resultsData.results.length; i++) {
                        var result = resultsData.results[i];
                        dateAsked = result.askedOn.split(' ');
                        var listItem = "<li class='list-group-item' style='margin-bottom: 5px; border: none; border-bottom: 1px solid #ddd;'>"
                                + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                                + "<img src='/MobileHub/resources/img/default.png' class='img-circle img-responsive' alt='' /></div>"
                                + "<div class='col-xs-10 col-md-9'><div>"
                                + "<a style='font-size: 18px;' href='/MobileHub/index.php/questions/show/?id=" + result.questionId + "'>" + result.questionTitle + "</a>"
                                + "<div class='mic-info' style='font-size: 13px;'> Asked by <a href='/MobileHub/index.php/profile/?user=" + result.askerName + "'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
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
</script>