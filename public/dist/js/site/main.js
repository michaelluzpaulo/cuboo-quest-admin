function qs(elements) {
  return document.querySelector(elements);
}

function qsAll(elements) {
  return document.querySelectorAll(elements);
}
document.addEventListener("DOMContentLoaded", function (event) {
  if (qs(".content_text")) {
    const w = window.innerWidth;
    if (w < 900) {
      $(".content_text img").height("auto");
    }
  }

  if (qs("#form-component-newsletter")) {
    Newsletter.init();
  }

  if (qs("#form-contato")) {
    Contato.init();
  }
});
