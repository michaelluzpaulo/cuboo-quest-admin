const Tema = (function () {
   const _formIdPrincipal = "#form-tema-principal";
   const _formId = "#temaForm";
   const _tableId = "#temaTable";
   const _tableTdClass = "temaTableTd";
   const _modalId = "#temaModal";
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
            const id = $(this).attr("data-id");
            __update(id);
         });
         _initCache = true;
      }
   }

   function __actionsModal() {
      // $(".modify-select", _modalId).select2();
      $(".js-run-delete", _modalId).on("click", function () {
         __delete();
      });
      $(".js-run-clone", _modalId).on("click", function () {
         __clone();
      });

      $(_formId).on("submit", function (e) {
         if ($(_formId).valid()) {
            e.preventDefault();
            __save();
         }
      });

      let myModal = new bootstrap.Modal(qs(_modalId), {
         keyboard: false,
      });
      myModal.show();

      qs(_modalId).addEventListener("shown.bs.modal", function () {
         qs(`${_modalId} #titulo`).focus();
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
      let oTable = $(_tableId).DataTable();
      oTable.draw();
   }

   function __createTable() {
      $(_tableId).dataTable({
         bFilter: false,
         pageLength: 50,
         order: [0, "ASC"],
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
            url: "/admin/temas/data",
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
            titulo: { required: true, minlength: 3, maxlength: 70 },
         },
         messages: {
            titulo: { required: "Campo obrigatório" },
         },
      });
   }

   function __add() {
      $.loadmask();
      ModalFactory.create("temaModal", "xl");

      $(".modal-content", _modalId).load(
         "/admin/temas/create",
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
      ModalFactory.create("temaModal", "xl");

      $(".modal-content", _modalId).load(
         "/admin/temas/" + id + "/edit",
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
      const data = $(_formId).serializeJSON();
      const method = id ? "PUT" : "POST";
      const url = id ? "/admin/temas/" + id : "/admin/temas";

      $.loadmask();
      window
         .axios({
            method: method,
            url: url,
            data: { data: JSON.stringify(data) },
         })
         .then((response) => {
            const json = response.data;
            if (json.error == 0) {
               let step = 0;
               let message = json.message;
               __refreshTable();

               let fileElement = document.querySelector("#logo_img", _formId);
               if (fileElement.value != "") {
                  step++;
                  $.changeMaskTitle("ATUALIZANDO LOGO....");
                  let file = fileElement.files[0];

                  const formData = new FormData();
                  formData.append("logo_img", file);
                  formData.append("tipo", 1);

                  $.ajax({
                     url: "/admin/temas/" + json.data.id + "/foto",
                     type: "POST",
                     data: formData,
                     dataType: "json",
                     processData: false,
                     contentType: false,
                     success: function (retorno) {
                        message += retorno.message;
                        step--;
                     },
                     error: function (jqXHR, textStatus, errorThrown) {
                        ServiceHttp.exceptionAjax(
                           jqXHR,
                           textStatus,
                           errorThrown
                        );
                     },
                  });
               }

               fileElement = document.querySelector("#marca_img", _formId);
               if (fileElement.value != "") {
                  step++;
                  $.changeMaskTitle("ATUALIZANDO MARCA....");
                  let file = fileElement.files[0];
                  const formData = new FormData();
                  formData.append("marca_img", file);
                  formData.append("tipo", 2);

                  $.ajax({
                     url: "/admin/temas/" + json.data.id + "/foto",
                     type: "POST",
                     data: formData,
                     dataType: "json",
                     processData: false,
                     contentType: false,
                     success: function (retorno) {
                        message += retorno.message;
                        step--;
                     },
                     error: function (jqXHR, textStatus, errorThrown) {
                        ServiceHttp.exceptionAjax(
                           jqXHR,
                           textStatus,
                           errorThrown
                        );
                     },
                  });
               }

               fileElement = document.querySelector("#fundo_img", _formId);
               if (fileElement.value != "") {
                  step++;
                  $.changeMaskTitle("ATUALIZANDO FUNDO....");
                  let file = fileElement.files[0];
                  const formData = new FormData();
                  formData.append("fundo_img", file);
                  formData.append("tipo", 3);

                  $.ajax({
                     url: "/admin/temas/" + json.data.id + "/foto",
                     type: "POST",
                     data: formData,
                     dataType: "json",
                     processData: false,
                     contentType: false,
                     success: function (retorno) {
                        message += retorno.message;
                        step--;
                     },
                     error: function (jqXHR, textStatus, errorThrown) {
                        ServiceHttp.exceptionAjax(
                           jqXHR,
                           textStatus,
                           errorThrown
                        );
                     },
                  });
               }

               var tentativa = 0;
               var interval = setInterval(function () {
                  if (tentativa > 10 || step == 0) {
                     clearInterval(interval);
                     $.unloadmask();
                     Notify.success(message);
                     $(_modalId).hide();
                     $(_modalId).modal("hide");
                  }
                  tentativa++;
               }, 2000);
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
               url: "/admin/temas/" + $("#id", _formId).val(),
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

   function __clone() {
      const id = $("#id", _formId).val();
      Notify.confirm(
         "Você confirma a clonagem do registro?<br />Após a confirmação será impossível reverter o comando.",
         function () {
            $.ajax({
               type: "POST",
               url: `/admin/temas/${id}/clone`,
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
