
onFeedbackReturn = ( result ) ->

    if result.errCode
        alert result.message
    else
        window.location.href = '/message-center/feedback/success'

$ ->

    _fb_form = $('#fb-form')

    _fb_form.on 'submit', (event) ->

        event.preventDefault()

        $.post '/message-center/feedback/index', _fb_form.serialize(), onFeedbackReturn, 'json'

        return false