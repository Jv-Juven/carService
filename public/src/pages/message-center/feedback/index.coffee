
onFeedbackReturn = ( result ) ->
    if result.errCode
        alert result.message
    else
        window.location.href = '/message-center/feedback/success'

$ ->
    $('#fb-form').on 'submit', (event) ->
        event.preventDefault()

        _this = $(this)

        $.post _this.prop('action'), _this.serialize(), onFeedbackReturn, 'json'