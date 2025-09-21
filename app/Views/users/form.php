<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
  <div class="card shadow-sm rounded-3">
    <div class="card-body">
      <h3 class="mb-4">
        <?= esc($title) ?>
      </h3>

      <form action="<?= $action ?>" method="post">
        <?= csrf_field() ?>
        <fieldset class="border p-3 mb-4">
          <legend class="float-none w-auto px-3 h5">Credenziali utente</legend>
          <!-- Username -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Username</label>
            <input type="text"
              class="form-control"
              name="username"
              value="<?= esc($user->username ?? '') ?>"
              <?= $mode === 'view' ? 'readonly' : '' ?>
              required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email"
              class="form-control"
              name="email"
              value="<?= esc($user->email ?? '') ?>"
              <?= $mode === 'view' ? 'readonly' : '' ?>
              required>
          </div>


        </fieldset>

        <!-- Gruppi -->
        <fieldset class="border p-3 mb-4">
          <legend class="float-none w-auto px-3 h5">Gruppi di appartenenza</legend>
          <div class="mb-4">

            <div class="row">
              <?php foreach ($allGroups as $group => $value): ?>
                
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                      <?= $mode === 'view' ? 'disabled="disabled"' : '' ?>
                      name="groups[]"
                      value="<?= $group ?>"
                      id="group_<?= esc($value["title"]) ?>"
                      <?= isset($user->groups) && in_array($group, $user->groups) ? 'checked' : '' ?>
                    <label class="form-check-label" for="group_<?= esc($value["title"]) ?>">
                      <?= esc($value["title"]) ?>
                    </label>
                  </div>

              <?php endforeach; ?>
            </div>
          </div>
        </fieldset>



        <!-- Pulsanti -->
        <?php if ($mode !== 'view'): ?>
          <div class="d-flex justify-content-between">
            <a href="<?= site_url('utenti') ?>" class="btn btn-outline-secondary">Annulla</a>
            <button type="submit" class="btn btn-primary">Salva</button>
          </div>
        <?php else: ?>
          <a href="<?= site_url('utenti') ?>" class="btn btn-outline-secondary">Torna indietro</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>