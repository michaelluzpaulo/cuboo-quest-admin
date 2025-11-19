(function ($) {
  $.loadmask = function () {
    $("body").append(
      '<div id="loadmask" class="modal  show" style="display:block;padding-right:15px;background-color:rgba(30, 30, 30,0.9)"><div class="modal-dialog" style="margin-top: 20%;text-align:center;color:#fff"> <span class="loader"></span><br /><br /><br /><br /><span class="loadmask-title">LOADING...</span></div></div>'
    );
    $("#loadmask").fadeIn();
  };
  $.changeLoadmask = function (texto) {
    $("#loadmask .loadmask-title").text(texto);
  };
  $.changeMaskTitle = function (texto) {
    $("#loadmask .loadmask-title").text(texto);
  };
  $.unloadmask = function () {
    $("#loadmask").fadeOut().remove();
  };
})(jQuery);
