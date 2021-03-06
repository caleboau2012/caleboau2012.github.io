<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the Spanish language pack for the base application.
 * Portions created by REDK Ingenier??a del Software S.L..
 * All Rights Reserved.
 * Contributor(s): REDK Software Engineering (www.redk.net)
 ********************************************************************************/
 
$mod_strings = array (
  'LBL_RE' => 'RE:',
  'ERR_BAD_LOGIN_PASSWORD' => 'Usuario o contrase??a incorrecta',
  'ERR_BODY_TOO_LONG' => '\\rEl texto del cuerpo es demasiado largo para capturar el email COMPLETO. Truncado.',
  'ERR_INI_ZLIB' => 'No pudo deshabilitarse la compresi??n Zlib temporalmente.  Puede que "Comprobar Configuraci??n" falle.',
  'ERR_MAILBOX_FAIL' => 'No se pudo recuperar ninguna cuenta de correo.',
  'ERR_NO_IMAP' => 'No se han encontrado las librer??as de IMAP.  Por favor, resuelva esto antes de continuar con la configuraci??n de correo entrante',
  'ERR_NO_OPTS_SAVED' => 'No se han guardado valores ??ptimos con su cuenta de correo entrante.  Por favor, revise la configuraci??n',
  'ERR_TEST_MAILBOX' => 'Por favor, compruebe su configuraci??n e int??ntelo de nuevo.',
  'LBL_APPLY_OPTIMUMS' => 'Aplicar Valores ??ptimos',
  'LBL_ASSIGN_TO_USER' => 'Asignar a Usuario',
  'LBL_AUTOREPLY_OPTIONS' => 'Opciones de Respuesta Autom??tica',
  'LBL_AUTOREPLY' => 'Plantilla de Respuesta Autom??tica',
  'LBL_AUTOREPLY_HELP' => 'Seleccione una respuesta autom??tica para notificar a los remitentes de correo que su respuesta ha sido recibida.',
  'LBL_BASIC' => 'Informaci??n de la Cuenta de Correo',
  'LBL_CASE_MACRO' => 'Macro de Casos',
  'LBL_CASE_MACRO_DESC' => 'Establece la macro que ser?? analizada y utilizada para vincular el email importado a un Caso.',
  'LBL_CASE_MACRO_DESC2' => 'Establezca ??sto a cualquier valor que desee, pero preserve el <b>"%1"</b>.',
  'LBL_CERT_DESC' => 'Fozar la validaci??n del Certificado de Seguridad del servidor - no utilizar en certificados no firmados por una autoridad ra??z reconocida.',
  'LBL_CERT' => 'Validar Certificado',
  'LBL_CLOSE_POPUP' => 'Cerrar Ventana',
  'LBL_CREATE_NEW_GROUP' => '--Crear Grupo al Guardar--',
  'LBL_CREATE_TEMPLATE' => 'Crear',
  'LBL_SUBSCRIBE_FOLDERS' => 'Suscribirse a Carpetas',
  'LBL_DEFAULT_FROM_ADDR' => 'Por defecto:',
  'LBL_DEFAULT_FROM_NAME' => 'Por defecto:',
  'LBL_DELETE_SEEN' => 'Eliminar Emails Le??dos Tras Importaci??n',
  'LBL_EDIT_TEMPLATE' => 'Editar',
  'LBL_EMAIL_OPTIONS' => 'Opciones de Gesti??n de Correo',
  'LBL_EMAIL_BOUNCE_OPTIONS' => 'Opciones de Gesti??n de Rebotes',
  'LBL_FILTER_DOMAIN_DESC' => 'Especificar un dominio al cual no se enviar??n respuestas autom??ticas.',
  'LBL_ASSIGN_TO_GROUP_FOLDER_DESC' => 'Seleccione esta opci??n para se creen autom??ticamente registros de correo en Sugar para todos los correos entrantes.',
  'LBL_POSSIBLE_ACTION_DESC' => 'Para usar la opci??n Nuevo Caso, debe seleccionar una Carpeta de Grupo',
  'LBL_FILTER_DOMAIN' => 'No enviar Respuestas Autom??ticas a este Dominio',
  'LBL_FIND_OPTIMUM_KEY' => 'f',
  'LBL_FIND_OPTIMUM_MSG' => '<br>Buscando variables ??ptimas de conexi??n.',
  'LBL_FIND_OPTIMUM_TITLE' => 'Buscar Configuraci??n ??ptima',
  'LBL_FIND_SSL_WARN' => '<br>La comprobaci??n de SSL puede durar bastante tiempo.  Por favor, tenga paciencia.<br>',
  'LBL_FORCE_DESC' => 'Algunos servidores IMAP/POP3 requieren opciones especiales. Marque para forzar una opci??n negativa al conectar (ej., /notls)',
  'LBL_FORCE' => 'Forzar Negativo',
  'LBL_FOUND_MAILBOXES' => 'Se han encontrado las siguientes carpetas utilizables.<br>Haga clic en una para seleccionarla:',
  'LBL_FOUND_OPTIMUM_MSG' => '<br>Opciones ??ptimas encontradas.	Presiones el siguiente bot??n para aplicarlas a su cuenta de correo.',
  'LBL_FROM_ADDR' => 'Direcci??n del remitente',
  'LBL_FROM_ADDR_DESC' => 'La direcci??n de correo electr??nico puesta aqu?? no aparezca en el campo &#39;De&#39; direcci??n del correo electr??nico del remitente debido a las restricciones impuestas por el proveedor de servicios de correo electr??nico. En estas circunstancias, la direcci??n de correo electr??nico que se define es la del servidor de correo saliente que esta configurado.',
  'LBL_FROM_NAME_ADDR' => 'Nombre/Correo del Remitente',
  'LBL_FROM_NAME' => 'Nombre del remitente',
  'LBL_GROUP_QUEUE' => 'Asignar a Grupo',
  'LBL_HOME' => 'Inicio',
  'LBL_LIST_MAILBOX_TYPE' => 'Utilizaci??n de la Cuenta de Correo',
  'LBL_LIST_NAME' => 'Nombre:',
  'LBL_LIST_GLOBAL_PERSONAL' => 'Tipo',
  'LBL_LIST_SERVER_URL' => 'Servidor de Correo',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LOGIN' => 'Nombre de Usuario',
  'LBL_MAILBOX_DEFAULT' => 'INBOX',
  'LBL_MAILBOX_SSL_DESC' => 'Usar SSL en la conexi??n. Si no funciona, compruebe que su instalaci??n de PHP incluye "--with-imap-ssl" en la configuraci??n.',
  'LBL_MAILBOX_SSL' => 'Usar SSL',
  'LBL_MAILBOX_TYPE' => 'Acciones Posibles',
  'LBL_DISTRIBUTION_METHOD' => 'M??todo de Distribuci??n',
  'LBL_CREATE_CASE_REPLY_TEMPLATE' => 'Nueva Plantilla de Respuesta Autom??tica para Caso',
  'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP' => 'Seleccione una respuesta autom??tica para notificar a los remitentes de correo que se ha creado un nuevo caso. El correo contiene el n??mero de caso en la l??nea de Asunto acorde con la configuraci??n de la Macro de Caso.  Esta respuesta s??lo se enviar?? cuando se reciba el primer correo de un remitente.',
  'LBL_MAILBOX' => 'Carpetas Monitorizadas',
  'LBL_TRASH_FOLDER' => 'Papelera',
  'LBL_GET_TRASH_FOLDER' => 'Obtener Papelera',
  'LBL_SENT_FOLDER' => 'Elementos Enviados',
  'LBL_GET_SENT_FOLDER' => 'Obtener Elementos Eliminados',
  'LBL_SELECT' => 'Seleccionar',
  'LBL_MARK_READ_DESC' => 'Importar y marcar mensajes como le??dos en el servidor de correo; no borrar.',
  'LBL_MARK_READ_NO' => 'Email marcado como borrado tras importaci??n',
  'LBL_MARK_READ_YES' => 'Email dejado en el servidor tras importaci??n',
  'LBL_MARK_READ' => 'Dejar mensajes en el servidor',
  'LBL_MAX_AUTO_REPLIES' => 'N??mero de respuestas autom??ticas',
  'LBL_MAX_AUTO_REPLIES_DESC' => 'Establece el m??ximo n??mero de respuestas autom??ticas a enviar a una ??nica direcci??n de correo durante un per??odo de 24 horas.',
  'LBL_PERSONAL_MODULE_NAME' => 'Cuenta de Correo Personal',
  'LBL_CREATE_CASE' => 'Crear Caso desde Correo',
  'LBL_CREATE_CASE_HELP' => 'Seleccione esta opci??n para crear autom??ticamente registros de casos en Sugar a partir de correos entrantes.',
  'LBL_MODULE_NAME' => 'Cuenta de Correo de Grupo',
  'LBL_BOUNCE_MODULE_NAME' => 'Bandeja de Gesti??n de Correo Rebotado',
  'LBL_MODULE_TITLE' => 'Correo Entrante',
  'LBL_NAME' => 'Nombre',
  'LBL_NONE' => 'Ninguno',
  'LBL_NO_OPTIMUMS' => 'No se han encontrado valores ??ptimos.  Por favor, compruebe su configuraci??n e int??ntelo de nuevo.',
  'LBL_ONLY_SINCE_DESC' => 'Al usar POP3, PHP no se pueden realizar filtros en mesajes Nuevos/No le??dos.  Esta opci??n permite que se soliciten mensajes desde la ??ltima vez que la bandeja fue consultada.  Esto mejorar?? significativamente el rendimiento si su servidor de correo no soporta IMAP.',
  'LBL_ONLY_SINCE_NO' => 'No. Comprobar contra todos los correos en el servidor de correo.',
  'LBL_ONLY_SINCE_YES' => 'S??.',
  'LBL_ONLY_SINCE' => 'Importar s??lo desde la ??ltima comprobaci??n',
  'LBL_OUTBOUND_SERVER' => 'Servidor de Correo Saliente',
  'LBL_PASSWORD_CHECK' => 'Comprobar Contrase??a',
  'LBL_PASSWORD' => 'Contrase??a',
  'LBL_POP3_SUCCESS' => 'Su prueba de conexi??n de POP3 tuvo ??xito.',
  'LBL_POPUP_FAILURE' => 'Prueba de conexi??n fallida. El error es el siguiente:',
  'LBL_POPUP_SUCCESS' => 'Prueba de conexi??n exitosa.  Su configuraci??n funciona.',
  'LBL_POPUP_TITLE' => 'Comprobar Configuraci??n',
  'LBL_GETTING_FOLDERS_LIST' => 'Obteniendo Lista de Carpetas',
  'LBL_SELECT_SUBSCRIBED_FOLDERS' => 'Seleccionar Carpetas Suscritas',
  'LBL_SELECT_TRASH_FOLDERS' => 'Seleccionar Papelera',
  'LBL_SELECT_SENT_FOLDERS' => 'Seleccionar Carpeta de Elementos Enviados',
  'LBL_DELETED_FOLDERS_LIST' => 'Las siguientes carpetas %s o no existen o han sido eliminadas del servidor',
  'LBL_PORT' => 'Puerto del Servidor de Correo',
  'LBL_QUEUE' => 'Cola de la Cuenta de Correo',
  'LBL_REPLY_NAME_ADDR' => 'Responder a Nombre/Correo',
  'LBL_REPLY_TO_NAME' => 'Nombre de "Responder A"',
  'LBL_REPLY_TO_ADDR' => 'Direcci??n de "Responder A"',
  'LBL_SAME_AS_ABOVE' => 'Usando el mismo Nombre/Direcci??n',
  'LBL_SAVE_RAW' => 'Guardar C??digo Fuente Original',
  'LBL_SAVE_RAW_DESC_1' => 'Seleccione "S??" si quiere preservar el c??digo fuente original para cada email importado.',
  'LBL_SAVE_RAW_DESC_2' => 'Los archivos adjuntos grandes pueden producir erroror en bases de datos configuradas de forma restringida o incorrecta.',
  'LBL_SERVER_OPTIONS' => 'Configuraci??n Avanzada',
  'LBL_SERVER_TYPE' => 'Protocolo del Servidor de Correo',
  'LBL_SERVER_URL' => 'Direcci??n del Servidor de Correo',
  'LBL_SSL_DESC' => 'Si su servidor de correo soporta conexiones seguras de sockets (SSL), habilitar esta opci??n forzar?? conexiones SSL al importar el correo.',
  'LBL_ASSIGN_TO_TEAM_DESC' => 'El equipo seleccionado tiene acceso a la cuenta de correo.',
  'LBL_SSL' => 'Usar SSL',
  'LBL_STATUS' => 'Estado',
  'LBL_SYSTEM_DEFAULT' => 'Por Defecto en el Sistema',
  'LBL_TEST_BUTTON_KEY' => 't',
  'LBL_TEST_BUTTON_TITLE' => 'Probar [Alt+T]',
  'LBL_TEST_SETTINGS' => 'Probar Configuraci??n',
  'LBL_TEST_SUCCESSFUL' => 'Conexi??n completada con ??xito.',
  'LBL_TEST_WAIT_MESSAGE' => 'Un momento, por favor...',
  'LBL_TLS_DESC' => 'Usar Transport Layer Security para conectarse al servidor de correo - s??lo use ??sto si su servidor de correo soporta este protocolo.',
  'LBL_TLS' => 'Usar TLS',
  'LBL_WARN_IMAP_TITLE' => 'Correo Entrante Deshabilitado',
  'LBL_WARN_IMAP' => 'Avisos:',
  'LBL_WARN_NO_IMAP' => 'El Correo Entrante <b>no puede</b> funcionar sin las librer??as de C del cliente de IMAP habilitadas/compiladas en el m??dulo de PHP.  Por favor, contacte con su administrador para resolver este problema.',
  'LNK_CREATE_GROUP' => 'Crear Nuevo Grupo',
  'LNK_LIST_CREATE_NEW_GROUP' => 'Nueva Cuenta de Correo de Grupo',
  'LNK_LIST_CREATE_NEW_BOUNCE' => 'Nueva Cuenta de Gesti??n de Rebotes',
  'LNK_LIST_MAILBOXES' => 'Todas las Cuentas de Correo',
  'LNK_LIST_QUEUES' => 'Todas las Colas',
  'LNK_LIST_SCHEDULER' => 'Planificadores',
  'LNK_LIST_TEST_IMPORT' => 'Probar Importaci??n de Correo',
  'LNK_NEW_QUEUES' => 'Crear Nueva Cola',
  'LNK_SEED_QUEUES' => 'Crear Cabeza de Serie para Colas de Equipos',
  'LBL_IS_PERSONAL' => 'personal',
  'LBL_GROUPFOLDER_ID' => 'Id de Carpeta de Grupo',
  'LBL_ASSIGN_TO_GROUP_FOLDER' => 'Asignar a Carpeta de Grupo',
  'LBL_ALLOW_OUTBOUND_GROUP_USAGE' => 'Permitir que los usuarios env??en correo usando el Nombre y la Direcci??n del campo "De" como direcci??n de respuesta',
  'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC' => 'Cuando se selecciona esta opci??n, el Nombre y Direcci??n del remitente asociados a la cuenta de correo de este grupo aparecer??n como una opci??n para el campo "De" al escribir un correo para los usuarios que tengan acceso a la cuenta de correo del grupo.',
  'LBL_STATUS_ACTIVE' => 'Activo',
  'LBL_STATUS_INACTIVE' => 'Inactivo',
  'LBL_IS_GROUP' => 'grupo',
  'LBL_ENABLE_AUTO_IMPORT' => 'Importar Correos Autom??ticamente',
  'LBL_WARNING_CHANGING_AUTO_IMPORT' => 'Aviso: Est?? modificando su configuraci??n de importaci??n autom??tica lo cual puede provocar p??rdida de datos.',
  'LBL_WARNING_CHANGING_AUTO_IMPORT_WITH_CREATE_CASE' => 'Aviso: La importaci??n autom??tica debe estar habilitada para la creaci??n autom??tica de casos.',
  'LBL_EDIT_LAYOUT' => 'Editar dise??o',
);