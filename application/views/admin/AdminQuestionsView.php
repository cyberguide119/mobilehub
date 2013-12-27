<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

<div id="page-wrapper">   
    <div class="row">
        <div class="col-lg-12">
            <h1>Questions <small>Questions Overview</small></h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="active"><i class="fa fa-bar-chart-o"></i> Questions</li>
            </ol>
        </div>
    </div><!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <table id="qTable">
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        $('#qTable').dataTable({
            "sAjaxSource": '/MobileHub/index.php/api/admin/question/details',
            "sServerMethod": "POST",
            "aoColumns": [{
                    "mData": "questionId",
                    "sTitle": "Id"
                }, {
                    "mData": "questionTitle",
                    "sTitle": "Question Title",
                    "mRender": function(url, type, row) {
                        return  '<a href="/MobileHub/index.php/question/show/?id=' + row['questionId'] + '">' + url + '</a>';
                    }
                }, {
                    "mData": "askedOn",
                    "sTitle": "Asked On"
                }, {
                    "mData": "askerName",
                    "sTitle": "Asked By",
                    "mRender": function(url, type, full) {
                        return  '<a href="/MobileHub/index.php/profile/?user=' + url + '">' + url + '</a>';
                    }
                }, {
                    "mData": "answerCount",
                    "sTitle": "Answers"
                }, {
                    "mData": "votes",
                    "sTitle": "Votes"
                }, {
                    "sTitle": "Action",
                    "bSortable": false,
                    "sClass": "center",
                    "mRender": function(url, type, row) {
                        return  '<a href="javascript: deleteAnswer(' + row['questionId'] + ');" class="btn btn-sm btn-danger" title="Delete Question"><i class="btn-icon-only glyphicon glyphicon-trash"></i></a>';
                    }
                }]
        });
    });
</script>