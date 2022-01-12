// jQuery Ready Function
$(function(){
    // Code hier ausführen sobald DOM bereit ist
$(document).on('change','[name=percentage]',function(e){
    let frage_id=$(this).data('frage-id');
    let kompetenzerhebungs_id=$(this).data('kompetenzerhebung-id');
    let percentage=$(this).val();
    $.post(
        'kompetenzerhebungspeichern.php',
        {frage_id:frage_id,kompetenzerhebungs_id:kompetenzerhebungs_id,percentage:percentage})
        .done(function(){
            alert("Done!");
        })
        .fail(function(){
            alert("Fail");
        })
    ;
});
});