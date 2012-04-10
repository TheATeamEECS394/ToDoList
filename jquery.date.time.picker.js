$(function() {
    /*var tpVars ={
    hour: '',
    minutes: '',
    period: ''

    }*/
    var options;

    var variables = {
        clock:{
            type:12  //12 for 12-hour clock, 24 for 24-hour clock
        },
        get:{
            /*hourDetails:function(filter) {
                if (filter = "max") {
                    return variables.clock.type;
                }
                else if (filter = "min") {
                    return 1;
                }
            },*/
            range: {
                hours: function(){
                   return new Array[2](1, variables.clock.type === 12 ? 12 : 24);
                },
                minutes: function(){
                   return new Array[2](0, 59);
                }
            }
        },
        options: null //hold extended options here
    }

    // Datepicker
    $('#datepicker').datepicker({
        //inline: true
    });

    // Slider
    $('#slider1').slider({
        orientation: "vertical",
        value: $('#tpSelectedTime .selHrs').val() == "" ? 4 : parseInt($('#tpSelectedTime .selHrs').val()),
        min: 2,
        max: 12,
        step: 1,
        slide: function(event, ui) {
            $('#tpSelectedTime .selHrs').val(parseInt(ui.value));
        }
    });
    // Slider
    $('#slider2').slider({
        orientation: "vertical",
        value: $('#tpSelectedTime .selMins').val() == "" ? 00 : parseInt($('#tpSelectedTime .selMins').val()),
        min: 00,
        max: 55,
        step: 5,
        slide: function(event, ui) {
            $('#tpSelectedTime .selMins').val((ui.value == 0) ? '00' : parseInt(ui.value));
        }
    });

    //Am Pm select event bind
    $('#tpPeriod a').bind('click', function() {
        if ($(this).attr('class')) {
            $('#tpSelectedTime .period')
                    .val($(this).attr('class'));
        }
        return false;
    });
    //Inline editor bind
    $('#tpSelectedTime input.selHrs').keyup(function(e) {
        if ((e.which <= 57 && e.which >= 48) && ($(this).val() >= 1 && $(this).val() <= 12 )) {
            //console.log("Which: "+e.which);
            $('#slider1').slider('value', parseInt($(this).val()));
            //console.log("Val: "+parseInt($(this).val()))
        } else {
            $(this).val($(this).val().slice(0, -1));
        }
        //if($(this).val() < 1){
        //    $(this).val(1);
        //}
    });
    //Inline editor bind
    $('#tpSelectedTime input.selMins').keyup(function(e) {
        if ((e.which <= 57 && e.which >= 48) && ($(this).val() >= 0 && $(this).val() <= 59 )) {
            //console.log("Which: "+e.which);
            $('#slider2').slider('value', parseInt($(this).val()));
            //console.log("Val: "+parseInt($(this).val()))
        } else {
            $(this).val($(this).val().slice(0, -1));
        }
        //if($(this).val() < 1){
        //    $(this).val(1);
        //}
    });

});