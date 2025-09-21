<div class="toast-container position-fixed top-0 start-50 translate-middle p-3 mt-5" style="z-index: 1100;">
<?php $alert = session('alert'); ?>
    <?php if (is_array($alert) && isset($alert['type'], $alert['message'])): ?>
        <div class="toast align-items-center text-bg-<?= esc($alert['type']) ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $alert['message'] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    toastElList.map(function (toastEl) {
      var toast = new bootstrap.Toast(toastEl, { delay: 4000 }) // 4s
      toast.show()
    })
  })
</script>