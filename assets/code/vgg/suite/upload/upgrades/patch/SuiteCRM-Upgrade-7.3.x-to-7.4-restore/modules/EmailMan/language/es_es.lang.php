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
  'LBL_SEND_DATE_TIME' => 'Fecha de Env??o',
  'LBL_IN_QUEUE' => 'En Proceso',
  'LBL_IN_QUEUE_DATE' => 'Fecha de Encolamiento',
  'ERR_INT_ONLY_EMAIL_PER_RUN' => 'Utilice ??nicamente valores enteros para especificar el n??mero de emails enviados por lote',
  'LBL_ATTACHMENT_AUDIT' => 'ha sido enviado.  No se ha duplicado en local para minimizar la utilizaci??n de espacio en el disco duro.',
  'LBL_CONFIGURE_SETTINGS' => 'Configurar Opciones de Correo',
  'LBL_CUSTOM_LOCATION' => 'Definido por el Usuario',
  'LBL_DEFAULT_LOCATION' => 'Por Defecto',
  'LBL_DISCLOSURE_TITLE' => 'A??adir Mensaje sobre Confidencialidad de Contenido a Cada Correo',
  'LBL_DISCLOSURE_TEXT_TITLE' => 'Confidencialidad de Contenido',
  'LBL_DISCLOSURE_TEXT_SAMPLE' => 'AVISO: Este mensaje de correo es para uso ??nico de su(s) destinatario(s) y puede contener informaci??n privada y confidencial. Queda prohibido cualquier tipo de revisi??n, uso, revelaci??n o distribuci??n no autorizada. Si usted no es el destinatario previsto, por favor, destruya todas las copias del mensaje original y notifique al remitente de forma que podamos corregir la direcci??n de correo en nuestro registro. Gracias.',
  'LBL_EMAIL_DEFAULT_CHARSET' => 'Redactar mensajes de email en este juego de caracteres',
  'LBL_EMAIL_DEFAULT_EDITOR' => 'Redactar correo usando este cliente',
  'LBL_EMAIL_DEFAULT_DELETE_ATTACHMENTS' => 'Eliminar archivos adjuntos y notas relacionadas junto a los Emails borrados',
  'LBL_EMAIL_GMAIL_DEFAULTS' => 'Rellenar previamente valores por defecto para Gmail&#153;',
  'LBL_EMAIL_PER_RUN_REQ' => 'N??mero de emails enviados por lote',
  'LBL_EMAIL_SMTP_SSL' => '??Habilitar SMTP sobre SSL?',
  'LBL_EMAIL_USER_TITLE' => 'Configuraci??n por Defecto de Email para el Usuario',
  'LBL_EMAIL_OUTBOUND_CONFIGURATION' => 'Configuraci??n de Correo Saliente',
  'LBL_EMAILS_PER_RUN' => 'N??mero de emails enviados por lote',
  'LBL_ID' => 'Id',
  'LBL_LIST_CAMPAIGN' => 'Campa??a',
  'LBL_LIST_FORM_PROCESSED_TITLE' => 'Procesados',
  'LBL_LIST_FORM_TITLE' => 'Cola',
  'LBL_LIST_FROM_EMAIL' => 'Email del Remitente',
  'LBL_LIST_FROM_NAME' => 'Nombre del Remitente',
  'LBL_LIST_IN_QUEUE' => 'En Proceso',
  'LBL_LIST_MESSAGE_NAME' => 'Mensaje de Marketing',
  'LBL_LIST_RECIPIENT_EMAIL' => 'Email del Destinatario',
  'LBL_LIST_RECIPIENT_NAME' => 'Nombre del Destinatario',
  'LBL_LIST_SEND_ATTEMPTS' => 'Intentos de Env??o',
  'LBL_LIST_SEND_DATE_TIME' => 'Enviar el',
  'LBL_LIST_USER_NAME' => 'Nombre de Usuario',
  'LBL_LOCATION_ONLY' => 'Ubicaci??n',
  'LBL_LOCATION_TRACK' => 'Ubicaci??n de los archivos de seguimiento de campa??a (como campaign_tracker.php)',
  'LBL_CAMP_MESSAGE_COPY' => 'Guardar copias de los mensajes de la campa??a:',
  'LBL_CAMP_MESSAGE_COPY_DESC' => '??Desea guardar copias completas de <bold>CADA</bold> mensaje de email enviado durante todas las campa??as?  <bold>Se recomienda el valor por defecto de no hacerlo</bold>.  Si elige no, s??lo se guardar?? la plantilla enviada y las variables para recrear el mensaje individual.',
  'LBL_MAIL_SENDTYPE' => 'Agente de Transferencia de Correo (MTA):',
  'LBL_MAIL_SMTPAUTH_REQ' => 'Usar Autenticaci??n SMTP:',
  'LBL_MAIL_SMTPPASS' => 'Contrase??a:',
  'LBL_MAIL_SMTPPORT' => 'Puerto SMTP:',
  'LBL_MAIL_SMTPSERVER' => 'Servidor de Correo SMTP:',
  'LBL_MAIL_SMTPUSER' => 'Usuario:',
  'LBL_CHOOSE_EMAIL_PROVIDER' => 'Elija su proveedor de Email:',
  'LBL_YAHOOMAIL_SMTPPASS' => 'Contrase??a de Yahoo! Mail:',
  'LBL_YAHOOMAIL_SMTPUSER' => 'ID de Yahoo! Mail:',
  'LBL_GMAIL_SMTPPASS' => 'Contrase??a de Gmail:',
  'LBL_GMAIL_SMTPUSER' => 'Direcci??n de Email de Gmail:',
  'LBL_EXCHANGE_SMTPPASS' => 'Contrase??a de Exchange:',
  'LBL_EXCHANGE_SMTPUSER' => 'Nombre de usuario de Exchange:',
  'LBL_EXCHANGE_SMTPPORT' => 'Puerto de Servidor Exchange:',
  'LBL_EXCHANGE_SMTPSERVER' => 'Servidor Exchange:',
  'LBL_EMAIL_LINK_TYPE' => 'Cliente de Correo',
  'LBL_EMAIL_LINK_TYPE_HELP' => '<b>Cliente de Correo Sugar:</b> Enviar correo utilizando el cliente de correo de la aplicaci??n Sugar.<br><b>Cliente de Correo Externo:</b> Enviar correo utilizando un cliente de correo fuera de la aplicaci??n Sugar, como Microsoft Outlook.',
  'LBL_MARKETING_ID' => 'Id de Marketing',
  'LBL_MODULE_ID' => 'EmailMan',
  'LBL_MODULE_NAME' => 'Configuraci??n de Correo',
  'LBL_CONFIGURE_CAMPAIGN_EMAIL_SETTINGS' => 'Configurar Opciones de Correo de la Campa??a',
  'LBL_MODULE_TITLE' => 'Administraci??n de Cola de Email Saliente',
  'LBL_NOTIFICATION_ON_DESC' => 'Cuando est?? habilitado, se enviar??n emails a los usuarios cuando se les asignen registros.',
  'LBL_NOTIFY_FROMADDRESS' => 'Direcci??n remitente:',
  'LBL_NOTIFY_FROMNAME' => 'Nombre remitente:',
  'LBL_NOTIFY_ON' => 'Notificaciones de Asignaci??n',
  'LBL_NOTIFY_SEND_BY_DEFAULT' => '??Enviar notificaciones a usuarios nuevos?',
  'LBL_NOTIFY_TITLE' => 'Opciones de Correo',
  'LBL_OLD_ID' => 'Id Antiguo',
  'LBL_OUTBOUND_EMAIL_TITLE' => 'Opciones de Correo Saliente',
  'LBL_RELATED_ID' => 'Id Relacionado',
  'LBL_RELATED_TYPE' => 'Tipo Relacionado',
  'LBL_SAVE_OUTBOUND_RAW' => 'Guardar los Emails Salientes en formato original',
  'LBL_SEARCH_FORM_PROCESSED_TITLE' => 'B??squeda de Procesados',
  'LBL_SEARCH_FORM_TITLE' => 'B??squeda de Colas',
  'LBL_VIEW_PROCESSED_EMAILS' => 'Ver Emails Procesados',
  'LBL_VIEW_QUEUED_EMAILS' => 'Ver Emails Encolados',
  'TRACKING_ENTRIES_LOCATION_DEFAULT_VALUE' => 'Valor en Config.php para site_url',
  'TXT_REMOVE_ME_ALT' => 'Para borrar su suscripci??n a esta lista de correo vaya a',
  'TXT_REMOVE_ME_CLICK' => 'haga clic aqu??',
  'TXT_REMOVE_ME' => 'Para borrar su suscripci??n a esta lista de correo',
  'LBL_NOTIFY_SEND_FROM_ASSIGNING_USER' => 'Enviar notificaci??n usando como remitente la direcci??n de email del usuario asignador',
  'LBL_SECURITY_TITLE' => 'Configuraci??n de Seguridad de Email',
  'LBL_SECURITY_DESC' => 'Marque aquello que NO deber??a ser permitido en Email entrante o mostradas en el m??dulo de Emails.',
  'LBL_SECURITY_APPLET' => 'Etiqueta Applet',
  'LBL_SECURITY_BASE' => 'Etiqueta Base',
  'LBL_SECURITY_EMBED' => 'Etiqueta Embed',
  'LBL_SECURITY_FORM' => 'Etiqueta Form',
  'LBL_SECURITY_FRAME' => 'Etiqueta Frame',
  'LBL_SECURITY_FRAMESET' => 'Etiqueta Frameset',
  'LBL_SECURITY_IFRAME' => 'Etiqueta iFrame',
  'LBL_SECURITY_IMPORT' => 'Etiqueta Import',
  'LBL_SECURITY_LAYER' => 'Etiqueta Layer',
  'LBL_SECURITY_LINK' => 'Etiqueta Link',
  'LBL_SECURITY_OBJECT' => 'Etiqueta Object',
  'LBL_SECURITY_OUTLOOK_DEFAULTS' => 'Seleccionar la configuraci??n m??nima de seguridad por defecto en Outlook (errores en la visualizaci??n del contenido).',
  'LBL_SECURITY_SCRIPT' => 'Etiqueta Script',
  'LBL_SECURITY_STYLE' => 'Etiqueta Style',
  'LBL_SECURITY_TOGGLE_ALL' => 'Cambiar Todas las Opciones',
  'LBL_SECURITY_XMP' => 'Etiqueta Xmp',
  'LBL_YES' => 'S??',
  'LBL_NO' => 'No',
  'LBL_PREPEND_TEST' => '[Prueba]:',
  'LBL_SEND_ATTEMPTS' => 'Intentos de Env??o',
  'LBL_OUTGOING_SECTION_HELP' => 'Configurar el servidor de correo saliente por defecto para enviar notificaciones de correo, incluyendo alertas de workflow.',
  'LBL_ALLOW_DEFAULT_SELECTION' => 'Permite a los usuarios utilizar esta cuenta para correo saliente:',
  'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'Cuando esta opci??n est?? seleccionada, todos los usuarios podr??n enviar correos utilizando la misma<br> cuenta de correo saliente para enviar notificaciones del sistema y alertas.  Si la opci??n no est?? seleccionada,<br> los usuarios podr??n utilizar el servidor de correo saliente una vez proporcionen la informaci??n sobre su propia cuenta.',
  'LBL_FROM_ADDRESS_HELP' => 'Cuando esta activado, el nombre del usuario e Email del usuario que asigna se inluir?? en el campo &#39;De&#39; del Email. Es posible que esta funcionalidad no funcione con servidores SMTP que no permiten el env??o desde una direcci??n de Email diferente a la de la cuenta del servidor.',
  'LBL_GMAIL_LOGO' => 'Gmail',
  'LBL_YAHOO_MAIL_LOGO' => 'Yahoo Mail',
  'LBL_EXCHANGE_LOGO' => 'Exchange',
  'LBL_HELP' => 'Ayuda',
);