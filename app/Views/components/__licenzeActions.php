<div class="dropdown">
    <button class="btn dropdown-toggle" type="button" id="azione" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-list"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li>
            <a class="dropdown-item" href="/licenze/visualizza/<?= $licenza->id ?>">
                <i class="bi bi-eye"></i>
                Visualizza
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/licenze/modifica/<?= $licenza->id ?>">
                <i class="bi bi-pencil"></i>
                Modifica
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <li class="">
            <a class="dropdown-item text-danger" href="/licenze/elimina/<?= $licenza->id ?>">
                <i class="bi bi-trash"></i>
                Elimina
            </a>
        </li>
    </ul>
</div>