if ($(".dataTable")[0]) {
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      emptyTable: "Nenhum registro encontrado",
      info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 até 0 de 0 registros",
      infoFiltered: "(Filtrados de _MAX_ registros)",
      infoPostFix: "",
      infoThousands: ".",
      lengthMenu: "_MENU_ resultados por página",
      loadingRecords: "",
      processing: "",
      zeroRecords: "Nenhum registro encontrado",
      search: "Pesquisar ",
      paginate: {
        next: '<i class="fa fa-angle-double-right"></i>',
        previous: '<i class="fa fa-angle-double-left"></i>',
        first: "Primeiro",
        last: "Último",
      },
      aria: {
        sortAscending: ": Ordenar colunas de forma ascendente",
        sortDescending: ": Ordenar colunas de forma descendente",
      },
    },
  });
}

jQuery.extend(jQuery.validator.messages, {
  required: "Obrigatório.",
  remote: "Corrigir este campo.",
  email: "E-mail inválido.",
  url: "Digite uma url válida.",
  date: "Digite uma data válida.",
  dateISO: "Digite uma data no formato (ISO).",
  number: "Digite um número válido.",
  digits: "Digite apenas dígitos.",
  creditcard: "Digite um número válido de cartão de crédito.",
  equalTo: "Digite o mesmo valor novamente.",
  accept: "Digite uma extensão válida.",
  maxlength: jQuery.validator.format("Não pode ser mais de {0} caracteres."),
  minlength: jQuery.validator.format("Precisa ser no mínimo {0} caracteres."),
  rangelength: jQuery.validator.format(
    "Precisa ser entre {0} e {1} caracteres."
  ),
  range: jQuery.validator.format("Deve ser entre {0} e {1}."),
  max: jQuery.validator.format("Máximo {0}."),
  min: jQuery.validator.format("Ḿínimo {0}."),
});

// $.extend($.fn.pickadate.defaults, {
//     monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
//     weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
//     today: 'Hoje',
//     close: 'Fechar',
//     clear: 'Limpar',
//     format:'dd/mm/yyyy',
//     formatSubmit: 'dd/mm/yyyy'
// })

//$.validator.messages.required = "Obrigatório";

// Do this before you initialize any of your modals
// $.fn.modal.Constructor.prototype.enforceFocus = function () {
// };

function qs(elements) {
  return document.querySelector(elements);
}
function qsAll(elements) {
  return document.querySelectorAll(elements);
}

$(document).ready(function () {
  $("body").fadeIn();

  $(function () {
    if ($('[data-toggle="tooltip"]')[0]) {
      $('[data-toggle="tooltip"]').tooltip();
    }
  });

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $.fn.modal.Constructor.prototype.enforceFocus = function () {
    $(document)
      .off("focusin.bs.modal") // guard against infinite focus loop
      .on(
        "focusin.bs.modal",
        $.proxy(function (e) {
          alert("tese");
          if (
            this.$element[0] !== e.target &&
            !this.$element.has(e.target).length &&
            // CKEditor compatibility fix start.
            !$(e.target).closest(".cke_dialog, .cke").length
            // CKEditor compatibility fix end.
          ) {
            this.$element.trigger("focus");
          }
        }, this)
      );
  };
});
