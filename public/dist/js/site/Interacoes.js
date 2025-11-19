var Interacoes = (function () {
  var _formId = '#form-interacoes'

  function __init() {
    __actions()
  }

  function __actions() {
    $(_formId).on('submit', function (e) {
      e.preventDefault()

      if ($('#interacao', _formId).val().length < 3) {
        alert('Preencha o campo interação! ')
        return false
      }

      $('#btn-interacao', _formId).attr('disabled', true)
      __save()
    })
  }

  /**
   * Salva o registro no banco de dados
   */
  function __save() {
    var data = $(_formId).serializeJSON()
    var empresa_id = $('#empresa_id', _formId).val()
    var codigo = $('#codigo', _formId).val()

    $.loadmask()

    setTimeout(function () {
      $.unloadmask()
    }, 4000)
    $.ajax({
      type: 'POST',
      url: `/api/${empresa_id}/comunicacao/${codigo}`,
      data: {
        data: JSON.stringify(data)
      },
      dataType: 'json',
      timeout: 120000,
      success: function (json) {
        $.unloadmask()
        if (json.error == 0) {
          alert(json.message)
          //reset
          document.querySelector(_formId).reset()
          setTimeout(function () {
            document.location.reload()
          }, 3000)
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown)
      }
    })
  }

  return {
    init: __init
  }
})()
