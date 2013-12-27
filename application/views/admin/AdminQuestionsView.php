<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

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
                    <tr><th>Sites</th></tr>
                </thead>
                <tbody>
                    <tr><td>SitePoint</td></tr>
                    <tr><td>Learnable</td></tr>
                    <tr><td>Flippa</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        $('#example').dataTable();
    });
</script>
<link href="<?php echo site_url('../resources/css/jtable.min.css') ?>" rel="stylesheet">
<script href="<?php echo site_url('../resources/js/jquery.jtable.min.js') ?>" type="text/javascript"></script>