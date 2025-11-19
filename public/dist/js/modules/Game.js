var Game = (function () {
   var _formIdPrincipal = "#form-game-principal";
   var _formId = "#gameForm";
   var _tableId = "#gameTable";
   var _tableTdClass = "gameTableTd";
   var _modalId = "#gameModal";
   var _initCache = false;

   function __init() {
      __createTable();
      __actions();
      __init2();
   }

   function __init2() {
      $(".run-finaliza-partida-manual", _formId).on("click", function (e) {
         e.preventDefault();
         __finalizaPartida();
      });
   }

   function __actions() {
      $("#form-game-principal").on("submit", function (e) {
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

      $(".run-finaliza-partida-manual", _formId).on("click", function (e) {
         e.preventDefault();
         __finalizaPartida();
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
         qs(`${_modalId} #nome`).focus();
      });
      qs(_modalId).addEventListener("hidden.bs.modal", function () {
         $(_modalId).remove();
      });
      Utils.setMask(_formId);
   }

   function __finalizaPartida() {
      Notify.confirm(
         "Você realmente quer finalizar a partida?<br />Após a confirmação será impossível reverter o comando.",
         function () {
            $.loadmask();
            $.ajax({
               type: "GET",
               url: "/admin/games/finaliza-partida/" + $("#id", _formId).val(),
               dataType: "json",
               timeout: 120000,
               success: function (json) {
                  $.unloadmask();
                  $("#confirmModal").modal("hide");
                  if ($(_modalId)[0]) {
                     $(_modalId).modal("hide");
                     __refreshTable();
                  }
                  Notify.success(json.message);
               },
               error: function (jqXHR, textStatus, errorThrown) {
                  ServiceHttp.exceptionAjax(jqXHR, textStatus, errorThrown);
               },
            });
         }
      );
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
            url: "/admin/games/data",
            type: "GET",
            dataSrc: function (json) {
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
         },
         columnDefs: [
            { targets: [3, 4, 5], sortable: false },
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
            nome: {
               required: true,
            },
         },
         messages: {},
      });
   }

   /**
    * Abre a janela para inserção de cadastro
    */
   function __add() {
      $.loadmask();
      ModalFactory.create("gameModal", "lg");

      $(".modal-content", _modalId).load(
         "/admin/games/create",
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
      ModalFactory.create("gameModal", "xl");

      $(".modal-content", _modalId).load(
         "/admin/games/" + id + "/edit",
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
      var url = id ? "/admin/games/" + id : "/admin/games";

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
               var message = "";
               message += json.message;
               __refreshTable();

               $.unloadmask();
               Notify.success(message);
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
               url: "/admin/games/" + $("#id", _formId).val(),
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
      init2: __init2,
   };
})();
