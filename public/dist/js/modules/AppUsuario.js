const AppUsuario = (function () {
  const _formIdPrincipal = "#form-app-usuario-principal";
  const _formId = "#appUsuarioForm";
  const _tableId = "#appUsuarioTable";
  const _tableTdClass = "appUsuarioTableTd";
  const _modalId = "#appUsuarioModal";
  let _initCache = false;

  function __init() {
    __createTable();
    __actions();
  }

  function __actions() {
    $(_formIdPrincipal).on("submit", function (e) {
      e.preventDefault();
      __refreshTable();
    });

    $(".run-add-cadastro").on("click", function (e) {
      __add();
    });

    if (!_initCache) {
      $(document).on("click", "." + _tableTdClass, function (e) {
        var id = $(this).attr("data-id");
        __update(id);
      });
      _initCache = true;
    }
  }

  function __actionsModal() {
    $(".modify-select", _modalId).select2();

    $(".run-btn-delete", _modalId).on("click", function () {
      __delete();
    });

    $(_formId).on("submit", function (e) {
      if ($(_formId).valid()) {
        e.preventDefault();
        __save();
      }
    });

    const myModal = new bootstrap.Modal(qs(_modalId), {
      keyboard: false,
    });
    myModal.show();

    qs(_modalId).addEventListener("shown.bs.modal", function () {
      qs(`${_modalId} #nome`).focus();
    });
    qs(_modalId).addEventListener("hidden.bs.modal", function () {
      $(_modalId).remove();
    });
    Utils.setMask(_formId);
  }

  function __refreshTable() {
    const oTable = $(_tableId).DataTable();
    oTable.draw();
  }

  function __createTable() {
    $(_tableId).dataTable({
      bFilter: false,
      pageLength: 25,
      order: [1, "asc"],
      //"sDom": '<"top"i>rt<"bottom"flp><"clear">',
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Todos"],
      ],
      lengthChange: true,
      pagingType: "full_numbers",
      processing: false,
      serverSide: true,
      bAutoWidth: false,
      ajax: {
        url: "/admin/app-usuarios/data",
        type: "GET",
        dataSrc: function (json) {
          console.log(json);
          $.unloadmask();
          if (json.success) {
            return json.data;
          } else {
            Notify.error(json.message);
          }
        },
      },
      fnServerParams: function (aoData) {
        $.loadmask();
        aoData["search[id]"] = $("#filtro_id").val();
        aoData["search[nome]"] = $("#filtro_nome").val();
        aoData["search[status]"] = $("#filtro_status").val();
      },
      columnDefs: [
        {
          targets: -2,
          createdCell: function (td, cellData, rowData, row, col) {
            if (rowData[3] == "S") {
              $(td)
                .css({
                  textAlign: "center",
                  paddingTop: "10px",
                })
                .html('<i class="fa fa-check text-success"></i>');
            } else {
              $(td)
                .css({ textAlign: "center", paddingTop: "10px" })
                .html(" - ");
              $(td).parent().addClass("tr-disabled");
            }
          },
        },
        {
          targets: -1,
          data: null,
          sortable: false,
          createdCell: function (td, cellData, rowData, row, col) {
            $(td)
              .css({
                textAlign: "center",
                padding: 0,
              })
              .html(
                '<button type="button" data-id="' +
                  rowData["DT_RowId"] +
                  '" class="btn btn-secondary ' +
                  _tableTdClass +
                  '"><i class="fa fa-edit"></i></button>'
              );
          },
        },
      ],
    });
  }

  /**
   * Abre a janela para inserção de cadastro
   */
  function __add() {
    $.loadmask();
    ModalFactory.create("appUsuarioModal", "lg");

    $(".modal-content", _modalId).load(
      "/admin/app-usuarios/create",
      function (responseText, textStatus, jqXHR) {
        if (textStatus === "success") {
          if (Validator.IsJsonString(responseText)) {
            var json = JSON.parse(responseText);
            Notify.setResponse(json);
          } else {
            __actionsModal();
            $(_formId).validate({
              errorPlacement: function (error, element) {
                $(element)
                  .closest("form")
                  .find("label[for='" + element.attr("id") + "']")
                  .append(error);
              },
              errorElement: "span",
              rules: {
                nome: {
                  required: true,
                },
                email: {
                  required: true,
                  email: true,
                },
              },
              messages: {
                nome: {
                  required: "Campo obrigatório",
                },
                email: {
                  required: "Campo obrigatório",
                  email: "O campo email deve conter um e-mail válido",
                },
              },
            });
          }
          $.unloadmask();
        } else {
          ServiceHttp.exceptionLoad(responseText, textStatus, jqXHR);
        }
      }
    );
  }

  /**
   * Abre a janela para alteração de cadastro
   * @param id
   */
  function __update(id) {
    $.loadmask();
    ModalFactory.create("appUsuarioModal", "lg");

    $(".modal-content", _modalId).load(
      "/admin/app-usuarios/" + id + "/edit",
      function (responseText, textStatus, jqXHR) {
        if (textStatus === "success") {
          if (Validator.IsJsonString(responseText)) {
            let json = JSON.parse(responseText);
            Notify.setResponse(json);
          } else {
            __actionsModal();
            $(_formId).validate({
              errorPlacement: function (error, element) {
                $(element)
                  .closest("form")
                  .find("label[for='" + element.attr("id") + "']")
                  .append(error);
              },
              errorElement: "span",
              rules: {
                nome: {
                  required: true,
                },
                email: {
                  required: true,
                  email: true,
                },
              },
              messages: {
                nome: {
                  required: "Campo obrigatório",
                },
                email: {
                  required: "Campo obrigatório",
                  email: "O campo email deve conter um e-mail válido",
                },
              },
            });
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
    var url = id ? "/admin/app-usuarios/" + id : "/admin/app-usuarios";

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
          __refreshTable();
          Notify.success(json.message);
          $(_modalId).hide();
          $(_modalId).modal("hide");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown);
      },
    });
  }

  /**
   * Remove o registro do banco de dados
   * @param id
   */
  function __delete() {
    Notify.confirm(
      "Você confirma a exclusão do registro?<br />Após a confirmação será impossível reverter o comando.",
      function () {
        $.ajax({
          type: "DELETE",
          url: "/admin/app-usuarios/" + $("#id", _formId).val(),
          dataType: "json",
          timeout: 120000,
          success: function (json) {
            $("#confirmModal").modal("hide");
            $(_modalId).modal("hide");
            Notify.success(json.message);
            __refreshTable();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown);
          },
        });
      }
    );
  }

  return {
    init: __init,
  };
})();
