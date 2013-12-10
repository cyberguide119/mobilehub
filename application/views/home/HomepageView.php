<div class="container">
    <div class="panel-body">
    <ul class="list-group">
        <?php foreach ($questions as $question):?>
            <li class="list-group-item" style="margin-bottom: 5px;">
                <div class="row" style="margin-right: -40px;">
                    <div class="col-xs-2 col-md-1">
                        <img src="http://placekitten.com/80/80" class="img-circle img-responsive" alt="" />
                    </div>
                    <div class="col-xs-10 col-md-9">
                    <div>
                        <a href="#">
                            <?php echo $question["questionTitle"] ?></a>
                        <div class="mic-info">
                            Asked by <a href="#"><?php echo $question["askerName"]; ?></a> on <?php echo date('d-m-Y',strtotime($question["askedOn"])); ?>
                        </div>
                    </div>
                    <div class="comment-text">
                        <br><?php echo $question["questionDescription"] ?>
                    </div>
                    <div class="action">
                        <?php foreach($question['tags'] as $tagName):?>
                        <button type="button" class="btn btn-info btn-xs" title="Approved" text="Category">
                            <?php echo $tagName; ?>
                        </button>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="vote-box" title="Votes">
                        <span class="vote-count"><?php echo $question["votes"]?></span>
                        <span class="vote-label">votes</span>
                    </div>
                    <div class="ans-count-box" title="Answers">
                        <span class="ans-count"><?php echo $question["answerCount"]?></span>
                        <span class="ans-label">answers</span> 
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach;?>        
    </ul>
</div>
    
</div>