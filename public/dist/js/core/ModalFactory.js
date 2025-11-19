var ModalFactory = {
  create: function (id, size = "xl") {
    const tpl = `
    <div class="modal fade in" id="${id}" tabindex="-1" data-bs-focus="false">
      <div class="modal-dialog modal-${size}"><div class="modal-content"></div></div>
    </div>`;

    $(".wrapper").before(tpl);
  },
  onClose: function (modal) {
    modal.on("hidden.bs.modal", function () {
      modal.remove();
      if ($(".modal").length) {
        $("body").addClass("modal-open");
      }
    });
  },
};
