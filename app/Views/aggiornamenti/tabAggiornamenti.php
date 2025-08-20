 <?php if (!empty($aggiornamenti)): ?>
     <table class="table table-bordered table-hover align-middle">
         <thead>
             <tr>
                <th>ID</th>
                <th>Data aggiornamento</th>
                <th>Versione</th>
                <th>Stato</th>
                <th>Azioni</th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($aggiornamenti as $a): ?>
                 <tr class="aggiornamento-row" data-id="<?= esc($a->id) ?>" style="cursor:pointer;">
                     <td><?= esc($a->id) ?></td>
                     <td><?= esc($a->dt_agg) ?></td>
                     <td><?= esc($a->versioni_id) ?></td>

                     <td>
                         <span class="badge <?= $a->stato ? 'bg-success' : 'bg-secondary' ?>">
                             <?= $a->stato ? 'Attiva' : 'Inattiva' ?>
                         </span>
                     </td>
                     <td>
                         <a href="/licenze/visualizza/<?= $a->id ?>" class="btn btn-sm btn-outline-primary" title="Visualizza">
                             <i class="bi bi-eye"></i>
                             <a href="/licenze/modifica/<?= $a->id ?>" class="btn btn-sm btn-outline-secondary" title="Modifica">
                                 <i class="bi bi-pencil"></i>
                             </a>
                             <a href="/licenze/elimina/<?= $a->id ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick=" return confirm('Sei sicuro di voler eliminare questo aggiornamento?');">
                                 <i class="bi bi-trash"></i>
                             </a>
                     </td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
     </table>
 <?php else: ?>
     <div class="alert alert-warning">
         <i class="bi bi-exclamation-triangle"></i> Nessun aggiornamento associato a questa licenza.
     </div>
 <?php endif; ?>