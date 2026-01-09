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
$cakeDescription = __('Configuración');
?>

<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<?php
$val = function (string $key, $default = '') use ($user) {
    return isset($user[$key]) && $user[$key] !== null ? $user[$key] : $default;
};


$valDate = function (string $key) use ($user) {
    if (!isset($user[$key]) || $user[$key] === null) return '';
    $v = $user[$key];

    if ($v instanceof \Cake\I18n\FrozenDate || $v instanceof \Cake\I18n\FrozenTime) {
        return $v->format('Y-m-d');
    }

    if (is_string($v)) {
        $s = trim($v);

        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $s)) {
            return substr($s, 0, 10);
        }

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $s)) {
            [$d, $m, $y] = explode('/', $s);
            return sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        }
    }

    return '';
};
?>

<div class="fh-page fh-config-page">
    <div class="fh-config-topbar">
        <div class="fh-config-left">
            <a class="fh-btn fh-btn-back"
                href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'home']) ?>">
                Atrás
            </a>
            <h1 class="fh-title">Configuración</h1>
        </div>

        <a class="fh-btn fh-btn-logout"
            href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'logout']) ?>">
            Cerrar sesión
        </a>
    </div>

    <div class="fh-config-grid">
        <section class="fh-card fh-config-card">
            <h2 class="fh-card-title">Editar datos personales</h2>

            <form id="fh-profile-form" class="fh-form" autocomplete="off" data-api-url="<?= $this->Url->build(['prefix' => 'Api', 'controller' => 'Api', 'action' => 'updateProfile', '_ext' => 'json']) ?>">
                <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">

                <div class="fh-form-grid">
                    <div class="fh-field">
                        <label>Nombre</label>
                        <input class="fh-input" type="text" name="name" required value="<?= h($val('name')) ?>"
                            placeholder="Nombre">
                    </div>

                    <div class="fh-field">
                        <label>Apellidos</label>
                        <input class="fh-input" type="text" name="lastname" required value="<?= h($val('lastname')) ?>"
                            placeholder="Apellidos">
                    </div>

                    <div class="fh-field">
                        <label>Correo electrónico</label>
                        <input class="fh-input" type="email" name="email" readonly value="<?= h($val('email')) ?>"
                            placeholder="Correo electrónico">
                        <small class="fh-help">El email no se puede modificar.</small>
                    </div>

                    <div class="fh-field">
                        <label>Teléfono</label>
                        <input class="fh-input" type="tel" name="phone" required value="<?= h($val('phone')) ?>"
                            placeholder="Teléfono">
                    </div>

                    <div class="fh-field">
                        <label>Ciudad</label>
                        <input class="fh-input" type="text" name="city" required value="<?= h($val('city')) ?>"
                            placeholder="Ciudad">
                    </div>

                    <div class="fh-field">
                        <label>Fecha de nacimiento</label>
                        <input class="fh-input" type="date" name="birthdate" required
                            value="<?= h($valDate('birthdate')) ?>">
                    </div>

                    <div class="fh-note">
                        Si desea cambiar la contraseña rellene ambos campos con la misma contraseña.
                    </div>

                    <div class="fh-field">
                        <label>Contraseña</label>
                        <input class="fh-input" type="password" name="password" placeholder="Contraseña">
                    </div>

                    <div class="fh-field">
                        <label>Repite la contraseña</label>
                        <input class="fh-input" type="password" name="password_confirm"
                            placeholder="Repite la contraseña">
                    </div>
                </div>

                <button type="submit" class="fh-btn fh-btn-primary fh-btn-full">
                    Confirmar datos
                </button>
            

                <div id="fh-profile-msg" class="fh-form-msg" style="display:none;"></div>
            </form>
        </section>

        <section class="fh-card fh-config-card">
            <h2 class="fh-card-title">Solicitud de eliminación</h2>

            <form id="fh-remove-form" class="fh-form" autocomplete="off"
                data-api-url="<?= $this->Url->build(['prefix' => 'Api', 'controller' => 'Api', 'action' => 'removeRequest', '_ext' => 'json']) ?>">
                <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">

                <div class="fh-field">
                    <label>Por favor detalle el problema</label>
                    <textarea class="fh-textarea" name="observations" maxlength="1000"
                        placeholder="Escribe aquí (máx. 1000 caracteres)"></textarea>
                    <small class="fh-help">Máximo 1000 caracteres.</small>
                </div>

                <label class="fh-check">
                    <input type="checkbox" name="keepanonymous" value="1">
                    <span>Uso anónimo</span>
                </label>

                <button type="submit" class="fh-btn fh-btn-primary fh-btn-full">
                    Enviar
                </button>

                <div id="fh-remove-msg" class="fh-form-msg" style="display:none;"></div>
            </form>
        </section>

    </div>
</div>

<script>
(() => {
    const form = document.getElementById('fh-profile-form');
    if (!form) return;

    const apiUrl = form.getAttribute('data-api-url');
    const msg = document.getElementById('fh-profile-msg');

    const showMsg = (text, ok) => {
        if (!msg) return;
        msg.style.display = 'block';
        msg.className = 'fh-form-msg ' + (ok ? 'is-success' : 'is-error');
        msg.textContent = text;
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (msg) { msg.style.display = 'none'; msg.className = 'fh-form-msg'; }

        try {
            const fd = new FormData(form);

            const required = ['name', 'lastname', 'phone', 'city', 'birthdate'];
            for (const k of required) {
                const v = (fd.get(k) || '').toString().trim();
                if (!v) {
                    showMsg('Rellena todos los campos obligatorios.', false);
                    return;
                }
            }

            const p1 = (fd.get('password') || '').toString().trim();
            const p2 = (fd.get('password_confirm') || '').toString().trim();

            if (p1 !== '' || p2 !== '') {
                if (p1 === '' || p2 === '') {
                    showMsg('Para cambiar la contraseña, rellena ambos campos.', false);
                    return;
                }
                if (p1 !== p2) {
                    showMsg('Las contraseñas no coinciden.', false);
                    return;
                }
            }

            const body = new URLSearchParams();
            for (const [k, v] of fd.entries()) body.append(k, v);

            const r = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: body.toString(),
                credentials: 'same-origin'
            });

            const raw = await r.text();
            let data = null;
            try { data = JSON.parse(raw); } catch (err) {}

            if (!r.ok) {
                showMsg(`HTTP ${r.status}: ${raw.slice(0, 160)}`, false);
                return;
            }

            const ok = (data && (data.success === true || data.Code === 'OK'));
            const text = data?.message || data?.Response || (ok ? 'Datos actualizados.' : 'No se pudieron guardar los cambios.');

            showMsg(text, ok);

        } catch (err) {
            showMsg('Error de red. Inténtalo de nuevo.', false);
            console.error(err);
        }
    });
})();
</script>

<script>
    (() => {
        const form = document.getElementById('fh-remove-form');
        if (!form) return;

        const apiUrl = form.getAttribute('data-api-url');
        const msg = document.getElementById('fh-remove-msg');

        const showMsg = (text, ok) => {
            if (!msg) return;
            msg.style.display = 'block';
            msg.className = 'fh-form-msg ' + (ok ? 'is-success' : 'is-error');
            msg.textContent = text;
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (msg) { msg.style.display = 'none'; msg.className = 'fh-form-msg'; }

            try {
                const fd = new FormData(form);

                const obs = (fd.get('observations') || '').toString().trim();
                if (!obs) {
                    showMsg('Escribe un motivo antes de enviar la solicitud.', false);
                    return;
                }
                fd.set('keepanonymous', fd.get('keepanonymous') ? '1' : '0');

                const body = new URLSearchParams();
                for (const [k, v] of fd.entries()) body.append(k, v);

                const r = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: body.toString(),
                    credentials: 'same-origin'
                });

                const raw = await r.text();
                let data = null;
                try { data = JSON.parse(raw); } catch (err) { }

                if (!r.ok) {
                    showMsg(`HTTP ${r.status}: ${raw.slice(0, 160)}`, false);
                    return;
                }

                const ok = (data && (data.success === true || data.Code === 'OK'));
                const text = data?.message || data?.Response || (ok ? 'Solicitud enviada correctamente.' : 'No se pudo enviar la solicitud.');

                showMsg(text, ok);

                if (ok) form.reset();

            } catch (err) {
                showMsg('Error de red. Inténtalo de nuevo.', false);
                console.error(err);
            }
        });
    })();
</script>