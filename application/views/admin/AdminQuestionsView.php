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
                    <tr><th class="site_name">Name</th><th>Url </th><th>Type</th><th>Last modified</th></tr>
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
            "aaData": [
                ["Sitepoint", "http://sitepoint.com", "Blog", "2013-10-15 10:30:00"],
                ["Flippa", "http://flippa.com", "Marketplace", "null"],
                ["99designs", "http://99designs.com", "Marketplace", "null"],
                ["Learnable", "http://learnable.com", "Online courses", "null"],
                ["Rubysource", "http://rubysource.com", "Blog", "2013-01-10 12:00:00"]
            ],
            "aoColumnDefs": [{
                    "sTitle": "Site name"
                            , "aTargets": ["site_name"]
                }, {
                    "aTargets": [1]
                            , "bSortable": false
                            , "mRender": function(url, type, full) {
                        return  '<a href="' + url + '">' + url + '</a>';
                    }
                }, {
                    "aTargets": [3]
                            , "sType": "date"
                            , "mRender": function(date, type, full) {
                        return (full[2] == "Blog")
                                ? new Date(date).toDateString()
                                : "N/A";
                    }
                }]
        });
    });
</script>