<script src="<?php echo site_url('../resources/js/jquery.bootpag.min.js') ?>"></script>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="/MobileHub/index.php">Home</a></li>
        <li class="active">Tags</li>
    </ol>
    <div>
        <h4>Questions tagged with <span id="tagName" class="label label-info">Default</span></h4>
        <br>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active" onclick="changeTab('recent', 0);"><a href="#home" data-toggle="tab">Recent</a></li>
            <li class="" onclick="changeTab('popular', 0);"><a href="#profile" data-toggle="tab">Popular</a></li>
            <li class="" onclick="changeTab('unanswered', 0);"><a href="#profile" data-toggle="tab">Unanswered</a></li>
            <li class="" onclick="changeTab('alltags', 0);"><a href="#profile" data-toggle="tab">All</a></li>
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