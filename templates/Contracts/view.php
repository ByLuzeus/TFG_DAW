<?php
$this->layout = 'admin-contracts';
$cakeDescription = __('FamHapp - Dashboard, Panel de administración');

/* ─── Exclusiones en array (separador “-” o “;”) ─── */
$exclusionList = [];
if ($contract->exclusions) {
    $exclusionList = preg_split('/[-;]+/', $contract->exclusions, -1, PREG_SPLIT_NO_EMPTY);
}
?>
<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<?= $menuadmin ?>
<div id="micontent" class="shown">
    <?= $headeradmin ?>

    <div class="properties form large-9 medium-8 columns content">
        <form>
            <!-- CABECERA -->
            <div id="panel_header">
                <h3><?= __('Contrato: {0}', h($contract->username)) ?></h3>

                <div id="action-buttons">
                    <a class="link-action" href="/contracts">
                        <span class="hidden-xs"><?= __('Volver') ?></span>
                        <i class="material-icons visible-xs-block">arrow_back</i>
                    </a>
                    <a class="link-action" href="/contracts/edit/<?= $contract->id ?>">
                        <span class="hidden-xs"><?= __('Editar') ?></span>
                        <i class="material-icons visible-xs-block">edit</i>
                    </a>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="container-fluid container-full-blanco container-edit">
                <!-- Columna izquierda -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">

                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Nombre de usuario') ?></p>
                            <p class="dato-data"><?= h($contract->username) ?></p>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Estado') ?></p>
                            <?php if ($contract->has('state')): ?>
                                <p class="dato-data">
                                    <?= $contract->state->id ?> - <?= h($contract->state->description) ?>
                                </p>
                            <?php else: ?>
                                <p class="dato-data"><?= h($contract->state_id) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Fecha inicio') ?></p>
                            <p class="dato-data"><?= $contract->startdate ?></p>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Fecha finalización') ?></p>
                            <p class="dato-data"><?= $contract->enddate ?></p>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo"><?= __('Fecha del contrato') ?></p>
                            <p class="dato-data"><?= $contract->contractdate ?></p>
                        </div>
                    </div>

                    <!-- Flags + Breaches -->
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Finalizado') ?></p>
                            <p class="dato-data"><?= $contract->ended ? 'Sí' : 'No' ?></p>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Activo') ?></p>
                            <p class="dato-data"><?= $contract->active ? 'Sí' : 'No' ?></p>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo"><?= __('Incumplimientos') ?></p>
                            <p class="dato-data"><?= h($contract->breaches) ?></p>
                        </div>
                    </div>

                    <!-- Bloque EXCLUSIONES -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <a class="link-action" data-toggle="collapse"
                               href="#collapseExclusions" role="button"
                               aria-expanded="false" aria-controls="collapseExclusions">
                                <?= __('Exclusiones') ?>
                            </a>
                        </div>
                    </div>

                    <div class="row collapse" id="collapseExclusions" style="margin-top:60px">
                        <div class="col-lg-12 col-md-12">
                            <?php if ($exclusionList): ?>
                                <?php foreach ($exclusionList as $pkg): ?>
                                    <p class="dato-data"><?= h(trim($pkg)) ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="dato-data text-muted"><?= __('(Sin exclusiones)') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
            </div>
        </form>
    </div>
</div>