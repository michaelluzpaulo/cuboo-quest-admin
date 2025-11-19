var MinhaConta = (function () {
  const _formId = "#minhaContaForm";
  const _modalId = "#minhaContaModal";
  let _initCache = false;

  function __actionsModal() {
    // $('.modify-select', _modalId).select2();

    $(_formId).on("submit", function (e) {
      if ($(_formId).valid()) {
        e.preventDefault();
        __save();
      }
    });

    var myModal = new bootstrap.Modal(qs(_modalId), {
      keyboard: false,
    });
    myModal.show();

    qs(_modalId).addEventListener("shown.bs.modal", function () {
      qs(`${_modalId} #name`).focus();
    });
    qs(_modalId).addEventListener("hidden.bs.modal", function () {
      $(_modalId).remove();
    });
    Utils.setMask(_formId);
  }

  /**
   * Abre a janela para alteração de cadastro
   * @param id
   */
  function __profile(id) {
    $.loadmask();
    ModalFactory.create("minhaContaModal");

    $(".modal-content", _modalId).load(
      "/admin/minha-conta/" + id + "/editProfile",
      function (responseText, textStatus, jqXHR) {
        //console.log(responseText);
        //console.log(textStatus);   success|error|abort|error|notmodified|parsererror|timeout
        // console.log(jqXHR);

        if (textStatus === "success") {
          if (Validator.IsJsonString(responseText)) {
            var json = JSON.parse(responseText);
            Notify.setResponse(json);
          } else {
            __actionsModal();
            // $(_formId).validate({
            //   errorPlacement: function (error, element) {
            //     $(element)
            //       .closest("form")
            //       .find("label[for='" + element.attr("id") + "']")
            //       .append(error);
            //   },
            //   errorElement: "span",
            //   rules: {
            //     nome: {
            //       required: true,
            //     },
            //     email: {
            //       required: true,
            //       email: true,
            //     },
            //     password: {
            //       // required: true,
            //       minlength: 8,
            //       maxlength: 12,
            //     },
            //     confirm_password: {
            //       //required: true,
            //       minlength: 8,
            //       maxlength: 12,
            //       equalTo: "#password",
            //     },
            //   },
            //   messages: {
            //     nome: {
            //       required: "Campo obrigatório",
            //     },
            //     email: {
            //       required: "Campo obrigatório",
            //       email: "O campo email deve conter um e-mail válido",
            //     },
            //     password: {
            //       //required: "Digite uma senha",
            //       minlength: "A senha precisa ter entre 8 e 12 caracteres",
            //       maxlength: "A senha precisa ter entre 8 e 12 caracteres",
            //     },
            //     confirm_password: {
            //       required: "Digite a senha novamente",
            //       equalTo: "Por favor digite a mesma senha",
            //       minlength: "A senha precisa ter entre 8 e 12 caracteres",
            //       maxlength: "A senha precisa ter entre 8 e 12 caracteres",
            //     },
            //   },
            // });
          }
          $.unloadmask();
        } else {
          ServiceHttp.exceptionLoad(responseText, textStatus, jqXHR);
        }
      }
    );
  }

  /**
   * Salva o registro no banco de dados
   */
  function __save() {
    var id = parseInt($("#id", _formId).val());
    var data = $(_formId).serializeJSON();
    var method = id ? "PUT" : "POST";
    var url = id ? "/admin/minha-conta/" + id : "/admin/minha-conta";

    $.loadmask();
    $.ajax({
      type: method,
      url: url,
      data: {
        data: JSON.stringify(data),
      },
      dataType: "json",
      timeout: 120000,
      success: function (json) {
        $.unloadmask();
        if (json.error == 0) {
          $(_modalId).hide();

          Notify.success(json.message);
          $(_modalId).modal("hide");
          //                    if (json.theme) {
          //                        Utils.changeSkin(json.theme);
          //                    }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown);
      },
    });
  }

  return {
    profile: __profile,
  };
})();
