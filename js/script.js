// jQuery Ready Function
$(function () {
    $(document).on('change', '[name=percentage]', function (e) {
        let question_id = $(this).data('question-id');
        let survey_id = $(this).data('survey-id');
        let percentage = $(this).val();
        $.post(
            'saveSurvey.php',
            {question_id: question_id, survey_id: survey_id, percentage: percentage})
            .done(function () {
                /*alert("Done!");*/
            })
            .fail(function () {
                alert("Fail");
            })
        ;
    });
});