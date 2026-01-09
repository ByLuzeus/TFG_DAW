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
$cakeDescription = __('Registro de tutor');
?>

<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<div class="fh-login-page">
    <div class="fh-login-card fh-login-card--wide">

        <div class="fh-login-logo">
            <?= $this->Html->image('nuevo/famhapp.png', [
                'alt' => 'FamHapp',
                'class' => 'fh-logo'
            ]) ?>
        </div>

        <div class="fh-login-title">
            <h1><?= __('Registrarse') ?></h1>
            <p><?= __('Crea tu cuenta de tutor para empezar a usar FamHapp.') ?></p>
        </div>

        <?= $this->Flash->render() ?>

        <div id="fh-register-msg" class="alert" style="display:none; margin: 14px auto 0; max-width: 560px;"></div>

        <?= $this->Form->create(null, [
            'class' => 'fh-login-form',
            'id' => 'fh-register-form',
            'url' => ['controller' => 'Famhapp', 'action' => 'registry'],
            'data-api-url' => $this->Url->build('/api/registerfather')
        ]) ?>

        <div class="fh-form-grid">

            <!-- Columna izquierda -->
            <div class="fh-form-col">

                <!-- Nombre de usuario -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <?= $this->Form->text('username', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Nombre de usuario'),
                        'required' => true,
                        'autocomplete' => 'off'
                    ]) ?>
                </div>

                <!-- Nombre -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-id-badge"></i>
                    </span>
                    <?= $this->Form->text('name', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Nombre'),
                        'required' => true
                    ]) ?>
                </div>

                <!-- Apellidos -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-id-badge"></i>
                    </span>
                    <?= $this->Form->text('lastname', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Apellidos'),
                        'required' => true
                    ]) ?>
                </div>

                <!-- Teléfono -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-phone"></i>
                    </span>
                    <?= $this->Form->text('phone', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Teléfono'),
                        'required' => true
                    ]) ?>
                </div>

                <!-- Ciudad -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-city"></i>
                    </span>
                    <?= $this->Form->text('city', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Ciudad'),
                        'required' => true
                    ]) ?>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="fh-form-col">

                <!-- Email -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <?= $this->Form->email('email', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Correo electrónico'),
                        'required' => true,
                        'autocomplete' => 'email'
                    ]) ?>
                </div>

                <!-- Género -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-venus-mars"></i>
                    </span>
                    <?= $this->Form->select('genre', [
                        'Masculino' => __('Masculino'),
                        'Femenino' => __('Femenino'),
                        'Otro' => __('Otro'),
                        'Prefiero no decirlo' => __('Prefiero no decirlo'),
                    ], [
                        'empty' => __('Género'),
                        'label' => false,
                        'class' => 'fh-input',
                        'required' => true
                    ]) ?>
                </div>

                <!-- Fecha de nacimiento -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <?= $this->Form->control('birthdate', [
                        'type' => 'date',
                        'label' => false,
                        'class' => 'fh-input',
                        'required' => true,
                        'max' => date('Y-m-d'),
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ]
                    ]) ?>
                </div>

                <!-- Contraseña -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <?= $this->Form->password('password', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Contraseña'),
                        'required' => true,
                        'autocomplete' => 'new-password'
                    ]) ?>
                </div>

                <!-- Confirmar contraseña -->
                <div class="fh-input-group">
                    <span class="fh-input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <?= $this->Form->password('password_confirm', [
                        'label' => false,
                        'class' => 'fh-input',
                        'placeholder' => __('Repite la contraseña'),
                        'required' => true
                    ]) ?>
                </div>

            </div>
        </div>

        <!-- Checkbox política de privacidad -->
        <div class="fh-privacy-row">
            <label class="fh-privacy-label">
                <input type="checkbox" name="accept_privacy" id="accept_privacy" required>
                <span class="fh-privacy-text">
                    <?= __('Acepto la') ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">
                        <?= __('Política de privacidad') ?>
                    </a>
                </span>
            </label>
        </div>

        <!-- Botón principal -->
        <div class="fh-actions-row" style="margin-top: 22px;">
            <?= $this->Form->button(__('Registrarse'), [
                'class' => 'fh-btn fh-btn-primary',
                'type' => 'submit',
                'id' => 'fh-register-submit'
            ]) ?>
        </div>

        <!-- Enlace para volver al login -->
        <div class="fh-login-help">
            <p><?= __('¿Ya tienes una cuenta?') ?></p>
            <a class="fh-link-underline"
                href="<?= $this->Url->build(['controller' => 'Adminusers', 'action' => 'login']) ?>">
                <?= __('Inicia sesión') ?>
            </a>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalTitle">
                    <?= __('Política de privacidad del servicio FAMHAPP') ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="fh-policy-body">

                    <p><strong>POLÍTICA DE PRIVACIDAD servicio FAMHAPP de TICandBOT</strong></p>

                    <p>TICandBOT Tecnología Educativa y Servicios Informáticos S.L, en adelante TICandBOT,
                        (“TICandBOT”, la “Empresa” o “nosotros”) se compromete a respetar y proteger su privacidad
                        y la de sus usuarios. Esta Política de Privacidad explica nuestras prácticas con respecto al
                        uso de los datos personales recogidos y tratados a través de nuestro Servicio Famhapp
                        (el “Servicio”). En esta Política de Privacidad le explicaremos nuestras prácticas relativas
                        al uso de datos de carácter personal obtenidos y/o tratados a través de nuestros Servicios.
                        Esta Política de Privacidad forma parte integrante de nuestras condiciones de uso.</p>

                    <p><strong>Resumen</strong><br>
                        TICandBOT y el servicio Famhapp tratan dos tipos de datos personales: sus datos de registro
                        y de cuenta, de los que TICandBOT es Responsable del Tratamiento y sus Datos de Usuario,
                        recopilados de sus dispositivos monitorizados asociados a su Cuenta, de los que Ud. es
                        responsable.</p>

                    <p>– Sus datos de cuenta y contacto se utilizan para administrar nuestra relación con usted,
                        incluida la activación, el soporte, la facturación y ventas adicionales.<br>
                        – Sus datos de Usuario y de los Dispositivos Monitorizados se tratan en su nombre, para
                        proporcionar los servicios de control y supervisión parental a través del panel de control.</p>

                    <p>Usted es el único responsable del uso del panel de control y del tratamiento de los datos
                        personales asociados con su Cuenta, que incluye, entre otros, recopilar, almacenar y analizar
                        datos personales de los Usuarios de los Dispositivos Monitorizados. La Plataforma TICandBOT y
                        su servicio Famhapp despliega automáticamente la configuración y las instrucciones dadas por
                        Usted y Usted es el único responsable de la configuración de este panel de control.</p>

                    <p>Los servicios y actividades prestados por TICandBOT y el servicio Famhapp pueden estar dirigidos
                        a menores de edad. El consentimiento para el tratamiento de los datos de los menores de edad
                        tiene
                        que ser otorgado por sus padres, tutores o representantes legales al realizar la inscripción en
                        los
                        servicios o actividades que TICandBOT y el servicio Famhapp ofrezcan u organicen, y sólo podrán
                        ser
                        revocados por éstos.</p>

                    <p>El servicio Famhapp está diseñado para ser utilizado en un entorno familiar, por los padres y no
                        por
                        los niños, y no recogemos a sabiendas información personal directamente de los niños menores de
                        14 años.
                        Usted garantiza que ha informado a los Usuarios que tienen 14 años o más que los Dispositivos
                        que utilizan
                        incluyen un software de control y monitoreo y han obtenido la autorización de dichos Usuarios
                        para este tipo
                        de actividad. Tanto TICandBOT como usted aceptan cumplir completamente con esta Política de
                        privacidad.</p>

                    <p>Cumpliendo con la Ley 3/2018, de 5 de diciembre de Protección de Datos Personales y garantía de
                        derechos
                        digitales, en el artículo 7 se establece que el tratamiento de datos personales de un menor de
                        edad
                        únicamente podrá fundarse en su consentimiento cuando sea mayor de catorce años. El tratamiento
                        de los datos
                        de menores de catorce años, fundado en el consentimiento, sólo será lícito si consta el del
                        titular de la
                        patria potestad o tutela.</p>

                    <h6>TICandBOT COMO RESPONSABLE DE TRATAMIENTO</h6>

                    <p>Por favor, tenga en cuenta que esta Sección NO regula el tratamiento de los datos del usuario de
                        los
                        Dispositivos Monitorizados (“Datos del Usuario”) por TICandBOT en calidad de Encargado del
                        Tratamiento,
                        el cual está regulado por la Sección B.</p>

                    <p><strong>1. Responsable de Tratamiento</strong><br>
                        El Responsable de Tratamiento es TICandBOT Tecnología Educativa y Servicios Informáticos S.L,
                        con domicilio
                        en Plaza Martínez Flamarique Nº5, bajo, 26004, Logroño, La Rioja, España. Puede contactar con
                        nuestro
                        Responsable de Tratamiento de Datos para hacerle llegar sus sugerencias, consultas, dudas o
                        reclamaciones,
                        para acceder a sus datos personales, o ejercer sus derechos, a través de esta dirección:
                        <a href="mailto:info@ticandbot.com">info@ticandbot.com</a>
                    </p>

                    <p><strong>2. Recogida y tratamiento de datos personales</strong><br>
                        TICandBOT y su servicio Famhapp recabará sus datos personales relativos al registro, pago y
                        formularios
                        enumerados a continuación (“Datos de Suscripción”).</p>

                    <p><em>Datos de Registro.</em> Al registrarse en el servicio Famhapp, recogemos los siguientes datos
                        personales: nombre, apellidos, domicilio social, NIF, dirección de correo electrónico. Estos
                        datos son
                        obligatorios y si no se proporcionan, la Cuenta del servicio Famhapp no podrá crearse para darse
                        de alta
                        en el servicio.</p>

                    <p><em>Pago.</em> Nuestro proveedor de pagos Redsys recopila determinados datos de pago que se
                        procesan de
                        acuerdo con sus condiciones y su política de privacidad, que se le facilitan durante el proceso
                        de pago.
                        Puede visitar <a href="https://redsys.es/politica-privacidad.html" target="_blank"
                            rel="noopener">
                            https://redsys.es/politica-privacidad.html</a> para obtener más información. Bajo ninguna
                        circunstancia
                        almacenaremos estos datos de pago en nuestros servidores. Podremos contratar a otros proveedores
                        de pago
                        que ofrezcan las garantías de seguridad de pago y cuyas condiciones serán indicadas antes de
                        iniciar el
                        proceso de pago.</p>

                    <p><em>Información sobre el equipo.</em> Debido a las normas de comunicación en Internet, cuando
                        Usted visita
                        nuestra Plataforma recibimos automáticamente la URL del sitio del que Usted proviene y del sitio
                        al que va
                        cuando abandone el sitio. También recibimos la dirección IP que emplea y el tipo de navegador
                        que está
                        utilizando. Utilizamos esta información para analizar tendencias generales y para ayudar a
                        mejorar el
                        Servicio. Esta información no es compartida con terceros sin su permiso.</p>

                    <p>Es importante que los datos personales que tenemos sobre usted sean exactos y estén actualizados.
                        Le
                        rogamos que nos mantenga informados si sus datos personales cambian durante su relación con
                        nosotros.</p>

                    <p><strong>Información que recogemos.</strong> Recogemos información que identifica, se relaciona
                        con,
                        describe, hace referencia, es razonablemente capaz de ser asociada con, o podría ser
                        razonablemente
                        vinculada, directa o indirectamente, con un consumidor particular, hogar o dispositivo
                        (“información
                        personal”).</p>

                    <p>Obtenemos estas categorías de información personal de las siguientes fuentes:<br>
                        – Directamente de usted (formularios que completa, características con las que interactúa).<br>
                        – Indirectamente de usted (observación de sus acciones dentro del servicio Famhapp).</p>

                    <p><strong>Finalidades.</strong> Los datos personales que recopilamos sobre usted se utilizan para
                        llevar a
                        cabo nuestro contrato y las comunicaciones con usted, para gestionar su Cuenta en el servicio
                        Famhapp y para
                        proporcionarle nuestros Servicios. También se utilizan para medir y mejorar los Servicios,
                        proporcionar
                        atención al cliente, enviar notificaciones por correo electrónico y, si usted dio su
                        consentimiento,
                        boletines y comunicaciones comerciales. Asimismo, utilizamos sus datos para garantizar el
                        cumplimiento de las
                        Condiciones, las leyes aplicables y otras obligaciones legales.</p>

                    <p><strong>Bases legales.</strong> El tratamiento de sus Datos de Suscripción se basa en:</p>
                    <ul>
                        <li>Preparación y ejecución del contrato.</li>
                        <li>Interés legítimo en la buena llevanza del negocio y la prestación de los servicios.</li>
                        <li>Cumplimiento de obligaciones legales.</li>
                    </ul>

                    <p>En general, no confiamos en el consentimiento como base legal salvo para comunicaciones
                        comerciales
                        propias por correo electrónico o SMS. Usted tiene derecho a retirar su consentimiento en
                        cualquier momento
                        contactando en <a href="mailto:info@ticandbot.com">info@ticandbot.com</a>.</p>

                    <p><strong>Optimización del Servicio.</strong> Podemos tratar información en forma agregada y no
                        identificable
                        para establecer perfiles y atributos de uso, mejorar y promocionar nuestros servicios.</p>

                    <p><strong>Comunicación de datos a terceros.</strong> Tratamos sus Datos de Suscripción de manera
                        confidencial.
                        No obstante, podremos revelar información para cumplir con obligaciones legales o a
                        Administraciones
                        Públicas, Jueces y Tribunales para la atención de posibles responsabilidades.</p>

                    <p>En el caso de instalación del software Famhapp para Dispositivos Monitorizados con iOS, los datos
                        transmitidos se canalizan a través de nuestros servidores, pudiendo recibir notificaciones de
                        terceros
                        relativas al comportamiento en línea del Usuario. Usted consiente la divulgación de sus datos de
                        contacto si
                        recibimos una Notificación o si la actividad del usuario puede ser perjudicial para la
                        prestación de los
                        Servicios.</p>

                    <p>Tras instalar el perfil MDM en dispositivos iOS, Famhapp tendrá acceso a todo el tráfico del
                        dispositivo,
                        que sólo va a los servidores de TICandBOT y no se comparte con terceros. Se recogen, entre
                        otros, nombres de
                        dominio, agente de usuario, versión del sistema operativo y URLs de búsqueda, con fines de
                        filtrado,
                        categorización e información a los padres/tutores.</p>

                    <p><strong>Conservación.</strong> Conservaremos sus Datos de Suscripción durante el tiempo necesario
                        para
                        prestar los Servicios contratados y, posteriormente, el tiempo necesario para cumplir
                        obligaciones legales
                        (en general, suscripción activa + 7 años bloqueados).</p>

                    <p><strong>Datos anonimizados.</strong> Para mejorar nuestros servicios, anonimizamos datos de
                        usuario y los
                        usamos de forma indefinida con fines estadísticos y analíticos, pudiendo compartirse de forma
                        agregada y
                        no identificable con terceros socios.</p>

                    <p><strong>3. Transferencias internacionales de datos.</strong><br>
                        El servicio Famhapp utiliza proveedores situados fuera del Espacio Económico Europeo. Entre
                        ellos:</p>

                    <ul>
                        <li>Google, Inc. – servicios de analítica, depuración de errores, servicio de la app y la web.
                        </li>
                        <li>Redsys – servicios de pago.</li>
                    </ul>

                    <p>En todos los casos, dichos proveedores cumplen los requisitos legales de transferencias
                        internacionales. Para más información puede escribir a
                        <a href="mailto:info@ticandbot.com">info@ticandbot.com</a>.
                    </p>

                    <p><strong>4. Seguridad de los Datos.</strong> Hemos adoptado medidas técnicas y organizativas
                        adecuadas
                        para proteger su información personal frente a accesos no autorizados, pérdida, alteración o uso
                        indebido.
                        En caso de violación de seguridad, le notificaremos a la mayor brevedad cuando proceda.</p>

                    <p><strong>5. Derechos sobre los Datos de Suscripción.</strong> Usted tiene, entre otros, los
                        derechos de:
                        acceso, rectificación, supresión, oposición, limitación del tratamiento, portabilidad, retirada
                        del
                        consentimiento y reclamación ante la AEPD.</p>

                    <p>Podrá ejercerlos contactando por escrito a la dirección postal indicada o por correo electrónico
                        a
                        <a href="mailto:info@ticandbot.com">info@ticandbot.com</a>, adjuntando copia de un documento
                        identificativo.
                    </p>

                    <p><strong>6. Ejercicio de sus derechos.</strong> Si considera que no ha obtenido satisfacción
                        plena, puede
                        presentar reclamación ante la Agencia Española de Protección de Datos (www.aepd.es).</p>

                    <p><strong>7. Tiempo y formato de respuesta.</strong> Intentamos responder en un plazo máximo de 45
                        días,
                        ampliable en caso necesario.</p>

                    <p><strong>8. No discriminación.</strong> No será discriminado por ejercer sus derechos de
                        protección de
                        datos.</p>

                    <p><strong>9. Comunicaciones comerciales.</strong> Como usuario del servicio Famhapp, puede recibir
                        comunicaciones comerciales, de las cuales podrá darse de baja en cualquier momento.</p>

                    <p><strong>10. General.</strong> Podemos modificar esta Política de Privacidad cuando sea necesario,
                        publicando la versión actualizada en nuestros canales.</p>

                    <h6>TICandBOT COMO ENCARGADO DE TRATAMIENTO (SECCIÓN B)</h6>

                    <p>La sección B regula el tratamiento de los datos de los Usuarios de los Dispositivos Monitorizados
                        cuando
                        actuamos como Encargado de Tratamiento, incluyendo objeto y duración, garantías, utilización de
                        los Datos de
                        Usuarios, configuración del servicio, conservación, eliminación de datos, obligaciones y
                        derechos de
                        TICandBOT, subencargados, transferencias internacionales, violaciones de seguridad y terminación
                        del
                        tratamiento.</p>

                    <p>Para más detalles sobre esta sección (incluyendo el Apéndice A sobre tipos de datos, categorías
                        de
                        interesados, subencargados autorizados y transferencia internacional de datos), puede consultar
                        la versión
                        íntegra de la Política de Privacidad disponible a través de TICandBOT o contactar en
                        <a href="mailto:info@ticandbot.com">info@ticandbot.com</a>.
                    </p>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <?= __('Cerrar') ?>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    (() => {
        const form = document.getElementById('fh-register-form');
        if (!form) return;

        const apiUrl = form.getAttribute('data-api-url') || '<?= $this->Url->build("/api/registerfather") ?>';
        const msgBox = document.getElementById('fh-register-msg');
        const submitBtn = document.getElementById('fh-register-submit');

        const showMsg = (text, ok) => {
            if (!msgBox) return;
            msgBox.style.display = 'block';
            msgBox.className = 'alert ' + (ok ? 'alert-success' : 'alert-danger');
            msgBox.textContent = text;
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const pass = form.querySelector('input[name="password"]')?.value || '';
            const pass2 = form.querySelector('input[name="password_confirm"]')?.value || '';
            const accept = document.getElementById('accept_privacy');

            if (accept && !accept.checked) {
                showMsg('Debes aceptar la Política de privacidad para continuar.', false);
                return;
            }
            if (pass !== pass2) {
                showMsg('Las contraseñas no coinciden.', false);
                return;
            }

            if (submitBtn) submitBtn.disabled = true;

            try {
                const fd = new FormData(form);
                fd.append('devicetype', 'web');
                fd.append('lastlanguage', 'es');

                const body = new URLSearchParams();
                for (const [k, v] of fd.entries()) {
                    body.append(k, v);
                }

                const r = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: body.toString()
                });
                console.log('STATUS', r.status, r.statusText);
                console.log('CONTENT-TYPE', r.headers.get('content-type'));

                const raw = await r.text();
                let data = null;
                try { data = JSON.parse(raw); } catch (err) { }

                if (!r.ok) {
                    showMsg(`HTTP ${r.status}: ${raw.slice(0, 160)}`, false);
                    return;
                }
                if (!data) {
                    showMsg(`Respuesta no JSON: ${raw.slice(0, 600)}`, false);
                    console.log('RAW RESPONSE:', raw);
                    return;
                }
                if (data.Code !== 'OK') {
                    showMsg(data.Response || 'No se ha podido registrar al usuario.', false);
                    return;
                }

                showMsg(data.Response || 'Padre registrado correctamente.', true);

                setTimeout(() => {
                    window.location.href = '<?= $this->Url->build(['controller' => 'Adminusers', 'action' => 'login']) ?>';
                }, 800);

            } catch (err) {
                showMsg('Error de red al registrar.', false);
                console.error(err);

            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    })();
</script>