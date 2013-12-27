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
            <table id="example">
                <thead>
                    <tr><th>Id</th><th>Title</th><th>Asked On</th><th>Asked By</th><th>Answers</th><th>Votes</th></tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        $('#example').dataTable({
            "sAjaxSource": '/MobileHub/index.php/api/admin/question/details',
            "sServerMethod": "POST",
            "aoColumns": [{
                    "mData": "questionId",
                    "sTitle": "Id"
                }, {
                    "mData": "questionTitle",
                    "sTitle": "Title"
                }, {
                    "mData": "askedOn"
                }, {
                    "mData": "askerName"
                }, {
                    "mData": "answerCount"
                }, {
                    "mData": "votes"
                } ]
        });
    });
</script>