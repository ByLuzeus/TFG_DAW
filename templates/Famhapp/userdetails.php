<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'famhapp';
$cakeDescription = __('Detalles de usuario');
$username = (string)($selectedUsername ?? '');
?>

<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<div class="fh-home fh-ud">

    <div class="fh-header fh-ud-header">
        <div class="fh-ud-left">
            <a class="fh-ud-backtext" href="<?= $this->Url->build('/famhapp/home') ?>">Atrás</a>
            <h1 class="famhapp-title fh-ud-title">Detalles de usuario</h1>
        </div>

        <a class="fh-ud-icon-btn" href="<?= $this->Url->build('/famhapp/rewards') ?>" title="Tienda">
            <img src="<?= $this->Url->image('famhapp/icons/ic_store.svg') ?>" alt="Tienda">
        </a>
    </div>

    <!-- Tarjeta azul superior -->
    <div class="fh-ud-usercard">
        <div class="fh-ud-avatarwrap">
            <img id="udAvatar" class="fh-ud-avatar"
                 src="<?= $this->Url->image('famhapp/avatars/avatar_lobo.svg') ?>" alt="Avatar">
        </div>

        <div class="fh-ud-fields">
            <div class="fh-ud-row">
                <span class="fh-ud-label">Username</span>
                <span class="fh-ud-value" id="udUsername">-</span>
            </div>
            <div class="fh-ud-row">
                <span class="fh-ud-label">Nombre de usuario</span>
                <span class="fh-ud-value" id="udFullname">-</span>
            </div>
            <div class="fh-ud-row">
                <span class="fh-ud-label">Puntos</span>
                <span class="fh-ud-value" id="udPoints">-</span>
            </div>
            <div class="fh-ud-row">
                <span class="fh-ud-label">Nivel</span>
                <span class="fh-ud-value" id="udLevel">-</span>
            </div>
        </div>
    </div>

    <div class="fh-home-grid fh-ud-grid">

        <!-- Contrato activo -->
        <section class="fh-section">
            <div class="fh-section-head">
                <h2>Contrato activo</h2>
            </div>

            <div class="fh-panel fh-ud-panel">
            











            </div>
        </section>

        <!-- Historial -->
        <section class="fh-section">
            <div class="fh-section-head">
                <h2>Historial de contratos</h2>
            </div>

            <div class="fh-panel fh-ud-panel fh-ud-historypanel">
                <div id="udHistory" class="fh-ud-history">
                    <div class="fh-ud-muted">Cargando historial...</div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
(() => {
    const escapeHtml = (s) =>
        String(s ?? '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));

    const username = <?= json_encode($username) ?>;
    const apiUrl = <?= json_encode($this->Url->build('/api/userdetails/' . $username . '.json')) ?>;

    const elHistory = document.getElementById('udHistory');

    const ymd = (dateStr) => {
        if (!dateStr) return '-';
        const s = String(dateStr);
        return s.length >= 10 ? s.slice(0, 10) : s;
    };

    const renderHistory = (contracts) => {
        if (!contracts || contracts.length === 0) {
            elHistory.innerHTML = `<div class="fh-ud-muted">No hay contratos.</div>`;
            return;
        }

        elHistory.innerHTML = contracts.map(c => {
            const breaches = Number(c.breaches || 0);
            const isBad = breaches > 0;

            return `
                <div class="fh-ud-contract ${isBad ? 'is-bad' : 'is-good'}">
                    <div class="fh-ud-contract-line">
                        <img class="fh-ud-ic" src="<?= $this->Url->image('famhapp/icons/ic_history.svg') ?>" alt="">
                        <span>${escapeHtml(ymd(c.startdate))} hasta ${escapeHtml(ymd(c.enddate))}</span>
                    </div>
                    <div class="fh-ud-contract-line">
                        <img class="fh-ud-ic" src="<?= $this->Url->image('famhapp/icons/ic_alert.svg') ?>" alt="">
                        <span>${isBad ? ('Tienes ' + breaches + ' incumplimiento' + (breaches === 1 ? '' : 's')) : 'Sin incumplimientos'}</span>
                    </div>
                </div>
            `;
        }).join('');
    };

    fetch(apiUrl, { method: 'GET', headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (!data || data.Code !== 'OK') {
                elHistory.innerHTML = `<div class="fh-ud-error">No se pudieron cargar los datos.</div>`;
                return;
            }

            const res = data.Response || {};
            const user = res.user || {};
            const level = res.level || null;

            document.getElementById('udUsername').textContent = user.username || '-';
            document.getElementById('udFullname').textContent =
                [user.name, user.lastname].filter(Boolean).join(' ') || '-';
            document.getElementById('udPoints').textContent = (user.rewardpoints ?? 0).toString();
            document.getElementById('udLevel').textContent = (level && level.description) ? level.description : '-';

            renderHistory(res.contracts || []);
        })
        .catch(() => {
            elHistory.innerHTML = `<div class="fh-ud-error">Error de red.</div>`;
        });
})();
</script>