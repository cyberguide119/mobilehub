<div class="question">
    <div class="question-title">
        <?php echo html_escape($question->questionTile); ?>
        <?php echo html_escape($question->questionDescription); ?>
    </div>
    <div class="date">
        <?php echo html_escape($question->askedOn); ?>
    </div>
</div>