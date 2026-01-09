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
$cakeDescription = __('Home');
$displayName = $sessionUser['name'] ?? $sessionUser['username'] ?? '';
?>

<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<div class="fh-home">

    <?php
    $isFather = (int)($sessionUser['isfather'] ?? 0) === 1;
    if (!$isFather):
        $name = $displayName ?: ($sessionUser['username'] ?? '');
    ?>
        <div class="fh-card fh-child-notice">
            <h2 class="fh-card-title">Hola<?= $name ? ', ' . h($name) : '' ?>.</h2>
            <p class="fh-card-text">
                Para acceder a las funcionalidades del hijo por favor use la app en formato movil,
                la web solo esta disponible para los tutores.
            </p>

            <div class="fh-actions">
                <a class="fh-btn fh-btn-primary" href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'logout']) ?>">
                    Volver al login
                </a>
            </div>
        </div>
    </div>
    <?php return; endif; ?>

    <!-- HEADER -->
    <div class="fh-header">
        <h1 class="famhapp-title">¡Bienvenido<?= $displayName ? ', ' . h($displayName) : '' ?>!</h1>

        <a class="fh-settings" href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'configuration']) ?>">
            <span class="fh-settings-ico">&#9881;</span>
            <span class="fh-settings-txt">Configuracion</span>
        </a>
    </div>

    <div class="fh-home-grid">

        <!-- COLUMNA IZQUIERDA -->
        <div class="fh-col-left">

            <!-- DISPOSITIVOS -->
            <section class="fh-section">
                <div class="fh-section-head">
                    <h2>Dispositivos</h2>

                    <a class="fh-add-device-btn" href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'adduser']) ?>">
                        <span class="fh-add-ico">+</span>
                        <span>Anadir dispositivo</span>
                    </a>
                </div>

                <div class="fh-panel fh-panel-devices">
                    <div id="fhDevices" class="fh-devices-list">
                        <div class="fh-empty">Cargando dispositivos...</div>
                    </div>
                </div>
            </section>

        </div>

        <!-- COLUMNA DERECHA -->
        <div class="fh-col-right">

            <!-- ACTIVIDAD RECIENTE -->
            <section class="fh-section">
                <div class="fh-section-head">
                    <h2>Actividad reciente</h2>
                </div>

                <div class="fh-panel fh-panel-activity">
                    <div id="fhActivity" class="fh-activity">
                        <div class="fh-empty">Cargando actividad...</div>
                    </div>
                </div>
            </section>

        </div>

    </div>

</div>

<script>
(() => {
    const escapeHtml = (s) =>
        String(s ?? '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));
    const elDevices = document.getElementById('fhDevices');
    if (elDevices) {
        const AVATARS = [
            'avatar_ave.svg','avatar_caballo.svg','avatar_camello.svg','avatar_cebra.svg','avatar_conejo.svg',
            'avatar_elefante.svg','avatar_ganso.svg','avatar_gato.svg','avatar_girafa.svg','avatar_leon.svg',
            'avatar_lobo.svg','avatar_mono.svg','avatar_pato.svg','avatar_perro.svg','avatar_pez.svg',
            'avatar_raton.svg','avatar_tigre.svg','avatar_toro.svg','avatar_tortuga.svg','avatar_vaca.svg'
        ];

        const avatarUrl = (avatarIndex) => {
            const idx = Number.isFinite(+avatarIndex) ? +avatarIndex : 0;
            const safe = Math.min(Math.max(idx, 0), AVATARS.length - 1);
            return '<?= $this->Url->image('famhapp/avatars/') ?>' + AVATARS[safe];
        };

        const userDetailsBaseUrl = '<?= rtrim($this->Url->build('/famhapp/userdetails/'), '/') . '/' ?>';

        fetch('<?= $this->Url->build('/api/listsons.json') ?>', {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data || data.Code !== 'OK') {
                elDevices.innerHTML = `<div class="fh-empty">${escapeHtml(data?.Response || 'No se han podido cargar los dispositivos.')}</div>`;
                return;
            }

            const users = Array.isArray(data.Response) ? data.Response : [];
            if (users.length === 0) {
                elDevices.innerHTML = `<div class="fh-empty">No hay dispositivos registrados.</div>`;
                return;
            }

            elDevices.innerHTML = users.map(u => {
                const username = (u.username ?? '').trim();
                const name = (u.name ?? '').trim();
                const lastname = (u.lastname ?? '').trim();
                const fullName = `${name}${lastname ? ' ' + lastname : ''}`.trim();

                const line1Left = username || 'usuario';
                const line1Right = fullName || 'Sin nombre';
                const line1 = `${line1Left} - ${line1Right}`;

                const hasContract = !!u.contract_active;
                const endDate = (u.contract_enddate ?? '').trim();
                const contractTxt = hasContract ? `Si${endDate ? ' (hasta ' + endDate + ')' : ''}` : 'No';

                const points = Number.isFinite(+u.rewardpoint)
                    ? +u.rewardpoint
                    : (Number.isFinite(+u.rewardpoints) ? +u.rewardpoints : 0);

                return `
                    <a class="fh-device-card" href="${userDetailsBaseUrl}${encodeURIComponent(username)}">
                        <span class="fh-device-avatar-ring">
                            <img class="fh-device-mini-avatar" src="${avatarUrl(u.avatar)}" alt="avatar">
                        </span>

                        <div class="fh-device-lines">
                            <div class="fh-device-line-1">${escapeHtml(line1)}</div>
                            <div class="fh-device-line-2"><strong>Contrato:</strong> ${escapeHtml(contractTxt)}</div>
                            <div class="fh-device-line-3"><strong>Puntos:</strong> ${escapeHtml(points)}</div>
                        </div>
                    </a>
                `;
            }).join('');
        })
        .catch(() => {
            elDevices.innerHTML = `<div class="fh-empty">Error cargando dispositivos.</div>`;
        });
    }

    const elAct = document.getElementById('fhActivity');
    if (!elAct) return;

    const iconBase = '<?= $this->Url->build('/img/famhapp/icons/') ?>';

    const iconForType = (id) => {
        const n = parseInt(id, 10);

        // Mapeo según tabla notifications de la bd
        if (n === 1) return iconBase + 'ic_peace.svg';          // Bienvenida
        if (n === 2) return iconBase + 'ic_history.svg';        // Usuario modificado
        if (n === 3) return iconBase + 'ic_arrow_up.svg';       // Subida de nivel

        // Contratos
        if ([4,5].includes(n)) return iconBase + 'ic_document.svg'; // Contrato creado / cumplido
        if ([6,7].includes(n)) return iconBase + 'ic_alert.svg';    // Incumplidos

        // Puntos / recompensas
        if (n === 8) return iconBase + 'ic_coins.svg';          // Puntos conseguidos
        if (n === 10) return iconBase + 'ic_history.svg';       // Fecha dispositivo modificada
        if (n === 11) return iconBase + 'ic_store.svg';         // Recompensa canjeada
        if (n === 12) return iconBase + 'ic_coins.svg';         // Recompensa creada
        if (n === 13) return iconBase + 'ic_history.svg';       // Cuenta menor creada

        return iconBase + 'ic_history.svg';
    };

    const labelForType = (id) => {
        const n = parseInt(id, 10);
        switch (n) {
            case 1:  return 'Bienvenida';
            case 2:  return 'Usuario modificado';
            case 3:  return 'Subida de nivel';
            case 4:  return 'Contrato creado';
            case 5:  return 'Contrato cumplido';
            case 6:  return 'Contrato incumplido';
            case 7:  return 'Compromiso incumplido';
            case 8:  return 'Puntos conseguidos';
            case 10: return 'Fecha dispositivo modificada';
            case 11: return 'Recompensa canjeada';
            case 12: return 'Recompensa creada';
            case 13: return 'Cuenta de menor creada';
            default: return 'Actividad';
        }
    };

    fetch('<?= $this->Url->build('/api/get-notifs-request.json') ?>', {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data || data.Code !== 'OK') {
            elAct.innerHTML = `<div class="fh-empty">${escapeHtml(data?.Response || 'No se ha podido cargar la actividad.')}</div>`;
            return;
        }

        const items = Array.isArray(data.Response) ? data.Response : [];
        if (items.length === 0) {
            elAct.innerHTML = `
                <div class="fh-activity-item">
                    <img class="fh-activity-ico" src="${iconForType(1)}" alt="">
                    <div class="fh-activity-body">
                        <div class="fh-activity-text">Sin actividad reciente</div>
                    </div>
                </div>
            `;
            return;
        }

        elAct.innerHTML = items.map(n => {
            const typeId = n?.notification_id ?? n?.idnotificationstype ?? n?.idnotificationtype ?? n?.type ?? 1;
            const username = (n?.username ?? '').trim();
            const label = labelForType(typeId);
            const extra = (n?.extradata ?? '').toString().trim();
            const date = n?.notificationdate ?? n?.date ?? n?.created ?? n?.datetime ?? '';
            const desc = extra ? `${label} (${extra})` : label;

            return `
                <div class="fh-activity-item">
                    <img class="fh-activity-ico" src="${iconForType(typeId)}" alt="">
                    <div class="fh-activity-body">
                        <div class="fh-activity-text"><strong>${escapeHtml(username)}:</strong> ${escapeHtml(desc)}</div>
                        <div class="fh-activity-date">${escapeHtml(date)}</div>
                    </div>
                </div>
            `;
        }).join('');
    })
    .catch(() => {
        elAct.innerHTML = `<div class="fh-empty">No se ha podido cargar la actividad.</div>`;
    });
})();
</script>
