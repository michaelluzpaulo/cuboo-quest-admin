var Utils = {
   /**
    * Calcula a idade a partir de uma data de nascimento
    * @param int dia Dia de nascimento
    * @param int mes Mes de nascimento
    * @param int ano Ano de nascimento
    * @return int Idade calculada
    */
   getIdade: function (dia, mes, ano) {
      var hoje = new Date();
      var idade = hoje.getFullYear() - ano;
      if (
         hoje.getMonth() + 1 < mes ||
         (hoje.getMonth() + 1 === mes && hoje.getDate() < dia)
      ) {
         idade--;
      }
      idade =
         idade < 1 ? "MENOS DE 1 ANO" : idade === 1 ? "1 ANO" : idade + " ANOS";

      return idade;
   },

   changeSkin: function (cls) {
      var my_skins = [
         "skin-blue",
         "skin-black",
         "skin-red",
         "skin-yellow",
         "skin-purple",
         "skin-green",
      ];
      $.each(my_skins, function (i) {
         $("body").removeClass(my_skins[i]);
      });
      $("body").addClass(cls);
      return false;
   },
   setLanguageDataTable: function () {
      return {
         sEmptyTable: "Nenhum registro encontrado",
         sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
         sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
         sInfoFiltered: "(Filtrados de _MAX_ registros)",
         sInfoPostFix: "",
         sInfoThousands: ".",
         sLengthMenu: "_MENU_ resultados por página",
         sLoadingRecords: "",
         sProcessing: "",
         sZeroRecords: "Nenhum registro encontrado",
         sSearch: "Pesquisar ",
         oPaginate: {
            sNext: '<i class="fa fa-angle-double-right"></i>',
            sPrevious: '<i class="fa fa-angle-double-left"></i>',
            sFirst: "Primeiro",
            sLast: "Último",
         },
         oAria: {
            sSortAscending: ": Ordenar colunas de forma ascendente",
            sSortDescending: ": Ordenar colunas de forma descendente",
         },
      };
   },

   setMask: function (form) {
      if ($(form).attr("disabled")) {
         $("input[type=checkbox]", form)
            .unbind()
            .on("click", function () {
               return false;
            });
         return false;
      }

      $("input[data-mask-type=telefone]", form).each(function () {
         var SPMaskBehavior = function (val) {
               return val.replace(/\D/g, "").length === 11
                  ? "(00) 00000-0000"
                  : "(00) 0000-00009";
            },
            spOptions = {
               onKeyPress: function (val, e, field, options) {
                  field.mask(SPMaskBehavior.apply({}, arguments), options);
               },
               placeholder: "(__) _____-____",
            };

         $(this).unmask();
         // $(this).mask("(99) 9999-9999");
         $(this).mask(SPMaskBehavior, spOptions);
      });

      $("input[data-mask-type=0800]", form).each(function () {
         $(this).unmask();
         $(this).mask("9999 999-9999");
      });

      $("input[data-mask-type=cep]", form).each(function () {
         $(this).unmask();
         $(this).mask("99999-999", { placeholder: "_____-___" });
      });

      $("input[data-mask-type=cpf]", form).each(function () {
         $(this).unmask();
         $(this).mask("999.999.999-99", { placeholder: "___.___.___-__" });
      });

      $("input[data-mask-type=cnpj]", form).each(function () {
         $(this).mask("99.999.999/9999-99", {
            placeholder: "__.___.___/____-__",
         });
      });

      $(
         "div[data-mask-type=datepicker],input[data-mask-type=datepicker]",
         form
      ).each(function () {
         $(this).datepicker({
            language: "pt-BR",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            format: "dd/mm/yyyy",
            clearBtn: !$(this).attr("required"),
         });

         //$(this).pickadate();
      });

      $("input[data-mask-type=date]", form).each(function () {
         $(this).unmask();
         $(this).mask("99/99/9999", { placeholder: "__/__/____" });
      });

      $("input[data-mask-type=moeda]", form).each(function () {
         $(this).priceFormat({
            prefix: "",
            centsSeparator: ",",
            thousandsSeparator: ".",
         });
      });

      $("input[data-mask-type=dia_mes]", form).each(function () {
         $(this).unmask();
         $(this).mask("99/99", { placeholder: "__/__" });
      });

      $("input[data-mask-type=mes_ano]", form).each(function () {
         $(this).unmask();
         $(this).mask("99/9999", { placeholder: "__/____" });
      });

      $("input[data-mask-type=hora_minuto]", form).each(function () {
         $(this).unmask();
         $(this).mask("99:99", { placeholder: "__:__" });
      });

      $("input[data-mask-type=number]", form).each(function () {
         $(this).unmask();
         $(this).keyup(function (event) {
            //Se for tab
            if (event.keyCode == 9) {
               $(this).select();
               return false;
            }
            if (
               (event.keyCode < 96 || event.keyCode > 105) &&
               (event.keyCode < 48 || event.keyCode > 57)
            ) {
               $(this).val(
                  $(this)
                     .val()
                     .replace(
                        String.fromCharCode(event.keyCode).toLowerCase(),
                        ""
                     )
               );
            }
         });
      });
      $(
         "input[type=text],input[type=email],input[type=number],textarea",
         form
      ).each(function () {
         $(this).focus(function () {
            $(this).select();
         });
         $(this).click(function () {
            $(this).select();
         });
      });
   },

   autoFocus: function (element) {
      setTimeout(function () {
         element.focus();
      }, 500);
   },
};

function repoFormatResult(repo) {
   if (!repo.id) return repo.text; // optgroup
   if (!repo.id) return state.text; // optgroup
   return (
      "<img class='medium-avatar' src='../dist/img/" +
      repo.avatar +
      "'/>Id: " +
      repo.id +
      "<br />" +
      repo.text
   );
}

function repoFormatSelection(repo) {
   return (
      "<img class='selection-avatar' src='../dist/img/" +
      repo.avatar +
      "'/>" +
      repo.text
   );
}

function format(state) {
   if (!state.id) return state.text; // optgroup
   return (
      "<img class='simple-avatar' src='../dist/img/" +
      state.avatar +
      "'/>" +
      state.text
   );
}

/**
 * Opens up a centered popup window.
 * @param {String} url      URL to open in the window.
 * @param {String} name     Popup name.
 * @param {int} width       Popup width.
 * @param {int} height      Popup height.
 * @param {String} options  window.open() options.
 * @return {Window}         Returns window instance.
 */
function popup(url, name, width, height, options) {
   var x = (screen.width - width) / 2,
      y = (screen.height - height) / 2;
   options +=
      ", left=" + x + ", top=" + y + ", width=" + width + ", height=" + height;
   options = options.replace(/^,/, "");

   var win = window.open(url, name, options);
   win.focus();
   return win;
}
