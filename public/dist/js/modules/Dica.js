const Dica = (function () {
   const _formIdPrincipal = "#form-dica-principal";
   const _formId = "#dicaForm";
   const _tableId = "#dicaTable";
   const _tableTdClass = "dicaTableTd";
   const _modalId = "#dicaModal";
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
      // $(".modify-select", _modalId).select2();
      $(".run-btn-delete", _modalId).on("click", function () {
         __delete();
      });
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
         qs(`${_modalId} #intent`).focus();
      });
      qs(_modalId).addEventListener("hidden.bs.modal", function () {
         $(_modalId).remove();
      });
      Utils.setMask(_formId);

      CKEDITOR.disableAutoInline = true;
      $(document).ready(function () {
         $(".ckeditor").ckeditor();
      });
   }

   /**
    * Recarrega os dados da tabela
    */
   function __refreshTable() {
      var oTable = $(_tableId).DataTable();
      oTable.draw();
   }

   function __createTable() {
      $(_tableId).dataTable({
         bFilter: false,
         pageLength: 50,
         order: [0, "DESC"],
         //"sDom": '<"top"i>rt<"bottom"flp><"clear">',
         lengthMenu: [
            [50, 100, 150, -1],
            [50, 100, 150, "Todos"],
         ],
         lengthChange: true,
         pagingType: "full_numbers",
         processing: false,
         serverSide: true,
         bAutoWidth: false,
         ajax: {
            url: "/admin/dicas/data",
            type: "GET",
            dataSrc: function (json) {
               //console.log(json);
               $.unloadmask();
               if (json.success) {
                  return json.data;
               } else {
                  console.log(json.message);
                  // Notify.error(json.message);
               }
            },
         },
         fnServerParams: function (aoData) {
            $.loadmask();
            aoData["search[id]"] = $("#filtro_id").val();
            aoData["search[titulo]"] = $("#filtro_titulo").val();
            aoData["search[tema]"] = $("#filtro_tema").val();
         },
         columnDefs: [
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

   function __valid() {
      $(_formId).validate({
         errorPlacement: function (error, element) {
            $(element)
               .closest("form")
               .find("label[for='" + element.attr("id") + "']")
               .append(error);
         },
         errorElement: "span",
         rules: {
            intent: {
               required: true,
            },
         },
         messages: {
            // intent: { required: "Campo obrigatório" },
         },
      });
   }

   function __add() {
      $.loadmask();
      ModalFactory.create("dicaModal", "lg");

      $(".modal-content", _modalId).load(
         "/admin/dicas/create",
         function (responseText, textStatus, jqXHR) {
            if (textStatus === "success") {
               if (Validator.IsJsonString(responseText)) {
                  var json = JSON.parse(responseText);
                  Notify.setResponse(json);
               } else {
                  __actionsModal();
                  __valid();
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
      ModalFactory.create("dicaModal", "lg");

      $(".modal-content", _modalId).load(
         "/admin/dicas/" + id + "/edit",
         function (responseText, textStatus, jqXHR) {
            if (textStatus === "success") {
               if (Validator.IsJsonString(responseText)) {
                  var json = JSON.parse(responseText);
                  Notify.setResponse(json);
               } else {
                  __actionsModal();
                  __valid();
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
      var url = id ? "/admin/dicas/" + id : "/admin/dicas";

      $.loadmask();
      window
         .axios({
            method: method,
            url: url,
            data: {
               data: JSON.stringify(data),
            },
         })
         .then((response) => {
            const json = response.data;
            if (json.error == 0) {
               $.unloadmask();
               if (json.error == 0) {
                  __refreshTable();
                  Notify.success(json.message);
                  $(_modalId).hide();
                  $(_modalId).modal("hide");
               }
            }
         })
         .catch((error) => {
            if (error.response) {
               ServiceHttp.exception(
                  error.response.status,
                  error.response.data.message
               );
            } else {
               console.log(error, error.message);
               ServiceHttp.exception(error.request.status, error.message);
            }
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
               url: "/admin/dicas/" + $("#id", _formId).val(),
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
