<div class="container">
    <div class="panel-body">
        <h4>Search Results</h4>
        <ul class="list-group">

        </ul>
    </div>

</div>
<script type="text/javascript">
    // Move this to a separate file and load it here.
    $(document).ready(function() {
        $.get("/MobileHub/index.php/api/search/questions?query=" + "<?php echo $results ?>", function(resultsData) {
            //$(".result").html(data);
            resultsData = jQuery.parseJSON(resultsData);
            for (var i = 0; i < resultsData.results.length; i++) {
                var result = resultsData.results[i];
                dateAsked = result.askedOn.split(' ');
                console.log(result);
                var listItem = "<li class='list-group-item' style='margin-bottom: 5px;'>"
                        + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                        + "<img src='http://placekitten.com/80/80' class='img-circle img-responsive' alt='' /></div>"
                        + "<div class='col-xs-10 col-md-9'><div>"
                        + "<a href='#'>"+ result.questionTitle +"</a>"
                        + "<div class='mic-info'> Asked by <a href='#'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
                        + "<div class='comment-text'><br>"
                        + result.questionDescription + "</div>"
                        + "<div class='action'>"
                        + getTagsString(result.tags)
                        +"</div></div>" //tags
                        + "<div class='col-md-2'><div class='vote-box' title='Votes'><span class='vote-count'>"
                        + result.votes + "</span><span class='vote-label'>votes</span></div>"
                        + "<div class='ans-count-box' title='Answers'><span class='ans-count'>"
                        + result.answerCount + "</span>"
                        + "<span class='ans-label'>answers</span></div></div></div></li>";
                $("ul.list-group")
                        .append(listItem);

            }
//            $.post("/MobileHub/index.php/search/results", resultsData, function(content) {
//                console.log(resultsData);
//                window.location.replace('/MobileHub/index.php/search/results');
//            }), "json";
            return true;
        });
        
        function getTagsString($tags)
        {
            var str = "";
            for(var i=0; i<$tags.length; i++){
                str += "<button type='button' class='btn btn-info btn-xs' title='Approved' text='Category'>"+$tags[i]+"</button>&nbsp";
            }
            return str;
        }
    });
</script>