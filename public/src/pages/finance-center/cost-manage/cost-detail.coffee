
init_datepicker = ->

    # jquery datepicker options
    datepicker_options = 
        dateFormat: 'yy-mm-dd'
        changeYear: true

    $('#date-start').datepicker datepicker_options
    $('#date-end').datepicker datepicker_options

$ ->
    init_datepicker()
