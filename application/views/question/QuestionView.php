<div class="container">
    <div class="row">
        <div class="col-md-1" style="margin-top: 26px;">
            <div class="vote-box" title="Votes">
                <span class="vote-count">0</span>
                <span class="vote-label">votes</span>
            </div>
            <div class="action">

                <button type="button" class="btn btn-success btn-xs" title="Edit">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                </button>
                <button type="button" class="btn btn-danger btn-xs" title="Approved">
                    <span class="glyphicon glyphicon-thumbs-down"></span>
                </button>
            </div>
        </div>
        <div class="col-md-11">
            <h2>Alice in Wonderland, part dos</h2>
            <p>'You ought to be ashamed of yourself for asking such a simple question,' added the Gryphon; and then they both sat silent and looked at poor Alice, who felt ready to sink into the earth. At last the Gryphon said to the Mock Turtle, 'Drive on, old fellow! Don't be all day about it!' and he went on in these words:
                'Yes, we went to school in the sea, though you mayn't believe it—'
                'I never said I didn't!' interrupted Alice.
                'You did,' said the Mock Turtle.</p>
            <div>
                <span class="badge badge-success">Posted 2012-08-02 20:47:04</span>
                <div class="pull-right">
                    <div class="action">
                        <button type="button" class="btn btn-info btn-xs" title="Approved" text="Category">
                            android                        </button>
                        <button type="button" class="btn btn-info btn-xs" title="Approved" text="Category">
                            blacklist                        </button>
                        <button type="button" class="btn btn-info btn-xs" title="Approved" text="Category">
                            help                        </button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Answers
                </div>
                <div class="panel-body">
                    <ul class="chat">
                        <li class="left clearfix"><span class="chat-img pull-left">
                                <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
                        <li class="left clearfix"><span class="chat-img pull-left">
                                <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>14 mins ago</small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h4>Your Answer</h4>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">                
                    <form accept-charset="UTF-8" action="" method="POST">
                        <textarea class="form-control" name="message" placeholder="Type in your message" rows="5" style="margin-bottom:10px;" id="ansDesc" maxlength="600"></textarea>
                        <button class="btn btn-info pull-right" type="submit">Post New Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#ansDesc').maxlength({
        alwaysShow: true
    });
</script>