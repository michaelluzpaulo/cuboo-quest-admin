const ScenarioOption = (function () {
   const _formId = "#optionForm";
   const _tableId = "#optionTable";
   const _tableTdClass = "optionTableTd";
   const _modalId = "#optionModal";
   let _initCache = false;
   let _scenarioId = 0;

   function __init(scenarioId) {
      _scenarioId = scenarioId;
      __createTable();
      __actions();
   }

   function __actions() {
      $(".run-add-option-cadastro").on("click", function (e) {
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

      qs(_modalId).addEventListener("hidden.bs.modal", function () {
         $(_modalId).remove();
      });
      Utils.setMask(_formId);

      CKEDITOR.disableAutoInline = true;
      $(document).ready(function () {
         $(".ckeditor").ckeditor();
      });
   }

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
            url: `/admin/scenarios/${_scenarioId}/options/data`,
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
            title: {
               required: true,
            },
         },
         messages: {
            title: { required: "Campo obrigatório" },
         },
      });
   }

   function __add() {
      $.loadmask();
      ModalFactory.create("optionModal", "lg");

      $(".modal-content", _modalId).load(
         `/admin/scenarios/${_scenarioId}/options/create`,
         function (responseText, textStatus, jqXHR) {
            if (textStatus === "success") {
               $(
                  ".notify, .notification, .alert-success, .alert-danger"
               ).fadeOut(300);

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

   function __update(id) {
      $.loadmask();
      ModalFactory.create("optionModal", "lg");

      $(".modal-content", _modalId).load(
         // "/admin/options/" + id + "/edit",
         `/admin/scenarios/${_scenarioId}/options/${id}/edit`,
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
      const id = parseInt($("#id", _formId).val());
      let data = $(_formId).serializeJSON();
      const method = id ? "PUT" : "POST";
      const url = id
         ? `/admin/scenarios/${_scenarioId}/options/${id}`
         : `/admin/scenarios/${_scenarioId}/options`;

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

   function __delete() {
      const id = $("#id", _formId).val();
      Notify.confirm(
         "Você confirma a exclusão do registro?<br />Após a confirmação será impossível reverter o comando.",
         function () {
            $.ajax({
               type: "DELETE",
               url:
                  `/admin/scenarios/${_scenarioId}/options/` +
                  $("#id", _formId).val(),
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
