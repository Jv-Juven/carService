
init_datepicker = ->

    # jquery datepicker options
    datepicker_options = 
        dateFormat: 'yy-mm'
        showButtonPanel: true
        changeYear: true
        changeMonth: true
        onClose: (dateText, inst) ->
            month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));

    $('#date').datepicker datepicker_options

$ ->
    init_datepicker()
