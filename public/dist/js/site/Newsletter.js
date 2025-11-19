var Newsletter = (function ($) {
  var _formId = "#form-component-newsletter";

  function __init() {
    __actions();
  }

  function __actions() {
    // Utils.setMask(_formId);

    $(_formId).on("submit", function (e) {
      e.preventDefault();

      if (!__valid()) {
        return false;
      }
      __save();
    });
  }

  function __valid() {
    var email = qs(_formId + " #email_newsletter").value;
    if (email.length < 3) {
      Notify.alert(`Preencha o campo e-mail! `, function () {
        qs(_formId + " #email_newsletter").focus();
      });
      return false;
    }

    return true;
  }

  /**
   * Salva o registro no banco de dados
   */
  function __save() {
    var data = $(_formId).serializeJSON();
    data.email = data.email.toLowerCase();

    $.loadmask();
    $.ajax({
      type: "POST",
      url: "/newsletter",
      data: {
        data: JSON.stringify(data),
      },
      dataType: "json",
      timeout: 120000,
      success: function (json) {
        $.unloadmask();
        if (json.error == 0) {
          Notify.success(json.message);
        }

        setTimeout(function () {
          document.location.reload();
        }, 5000);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown);
      },
    });
  }

  return {
    init: __init,
  };
})(jQuery);
