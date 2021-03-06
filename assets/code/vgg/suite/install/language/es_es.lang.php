<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/

$mod_strings = array(
	'LBL_BASIC_SEARCH'					=> 'B??squeda B??sica',
	'LBL_ADVANCED_SEARCH'				=> 'B??squeda Avanzada',
	'LBL_BASIC_TYPE'					=> 'Tipo B??sico',
	'LBL_ADVANCED_TYPE'					=> 'Tipo Avanzado',
	'LBL_SYSOPTS_1'						=> 'Seleccione de las siguientes opciones de configuraci??n del sistema.',
    'LBL_SYSOPTS_2'                     => '??Qu?? tipo de base de datos ser?? utilizada para la instancia de SuiteCRM que est?? a punto de instalar?',
	'LBL_SYSOPTS_CONFIG'				=> 'Configuraci??n del Sistema',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Especifique Tipo de Base de Datos',
    'LBL_SYSOPTS_DB_TITLE'              => 'Tipo de Base de Datos',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Por favor corrija los siguientes errores antes de continuar:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Por favor modifique los permisos de los siguientes directorios para permitir la escritura:',


    'ERR_DB_VERSION_FAILURE'			=> 'No se puede verificar la versi??n de la base de datos.',


	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Provea el nombre de usuario para el usuario administrador de SuiteCRM. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'Provea una contrase??a para el usuario administrador de SuiteCRM. ',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Se detectaron errores durante la verificaci??n de compatibilidad.  Para que su instalaci??n de SuiteCRM funcione correctamente, por favor realice los pasos necesarios para corregir los inconvenientes listados m??s abajo, y vuelva a presionar el bot??n volver a verificar, o vuelva a intentar realizar la instalaci??n nuevamente.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference est?? Activado (deber??a estar en Off en el archivo php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'No encontrado: el planificador de tareas de SuiteCRM se ejecutar?? con funcionalidad limitada.',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Para una mejor experiencia use IIS/FastCGI sapi, asigne fastcgi.logging en 0 en su archivo php.ini.',
    'ERR_CHECKSYS_IMAP'					=> 'No encontrado: Correo Entrante y Campa??as (Email) requieren la librer??a IMAP. No estar??n funcionales.',
    //'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC cannot be turned "On" when using MS SQL Server.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC no pueden estar activadas cuando se utiliza MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Advertencia: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Cambie este valor a  ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M o m??s en su archivo php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Versi??n m??nima requerida 4.1.2 - Se encontr??: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Fall?? la escritura y lectura de variables de sesi??n. No se puede avanzar con la instalaci??n.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'No es un directorio v??lido',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Advertencia: No se puede escribir',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Su versi??n de PHP no es soportada por SuiteCRM. Deber?? instalar una versi??n que sea compatible con la aplicaci??n SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versi??n para conocer las versiones de PHP soportadas. Su versi??n es ',
	'ERR_CHECKSYS_IIS_INVALID_VER'		=> 'Su versi??n de IIS no es soportada por SuiteCRM. Deber?? instalar una versi??n que sea compatible con la aplicaci??n SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versi??n para conocer las versiones de IIS soportadas. Su versi??n es ',
	'ERR_CHECKSYS_FASTCGI'              => 'Detectamos que no est?? utilizando un FastCGI handler mapping para PHP. Deber?? instalar/configurar una versi??n que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versi??n para conocer las versiones soportadas. Vea <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> para m??s detalles ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Para una mejor experiencia usando IIS/FastCGI sapi, asigne fastcgi.logging en 0 en su archivo php.ini.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Versi??n de PHP no soportada: ( ver',
    'LBL_DB_UNAVAILABLE'                => 'Base de datos no disponible',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'No se encontr?? Soporte de Base de Datos. Por favor aseg??rese de tener los drivers necesarios para alguna de las siguientes Base de Datos soportadas: MySQL o MS SqlServer. Puede que sea necesario descomentar la extensi??n correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versi??n de PHP. Por favor consulte el manual de PHP para m??s informaci??n sobre c??mo habilitar el Soporte de Base de Datos.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'No se encontraron las funciones de las librer??as de XML Parsing necesarias para ejecutar SuiteCRM. Puede que sea necesario descomentar la extensi??n correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versi??n de PHP. Por favor consulte el manual de PHP para m??s informaci??n.',
    'ERR_CHECKSYS_MBSTRING'             => 'No se encontraron las funciones asociadas con la extensi??n Multibyte Strings (mbstring) necesaria para ejecutar SuiteCRM. <br/><br/>Generalmente el m??dulo mbstring no est?? habilitado por defecto en PHP y debe ser activado con --enable-mbstring al momento de compilar PHP. Por favor consulte el manual de PHP para m??s informaci??n sobre c??mo habilitar mbstring.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'El par??metro session.save_path de su archivo de configuraci??n (php.ini) no est?? correctamente asignado, o est?? establecido un directorio que no existe. Puede que sea necesario asignar el par??metro save_path en el archivo php.ini o verificar que la carpeta establecida en save_path existe.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'El par??metro de configuraci??n session.save_path en su archivo de configuraci??n (php.ini) est?? asignado a un directorio que no tiene permisos de escritura. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al men?? propiedades y desactivar la opci??n "s??lo lectura".',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'El archivo de configuraci??n existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al men?? propiedades y desactivar la opci??n "s??lo lectura".',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'El archivo config override existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al men?? propiedades y desactivar la opci??n "s??lo lectura".',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'El directorio Custom existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al men?? propiedades y desactivar la opci??n "s??lo lectura".',
    // The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => 'Los archivos o directorios listados m??s abajo no se pueden escribir. Dependiendo de su Sistema Operativo, corregir esto puede requerir que cambie los permisos de los archivos o directorio padre (chmod 755), o click derecho en la carpeta padre, desactivar la opci??n "s??lo lectura" y aplicarla a todas las subcarpetas. ',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode est?? activado (puede ser conveniente deshabilitarlo en php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'ZLib no se encontr??: SuiteCRM alcanza grandes beneficios de performance con la compresi??n zlib.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP no se encontr??: SuiteCRM necesita soporte ZIP para procesar archivos comprimidos.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE no se encontr??: SuiteCRM necesita la librer??a PCRE para procesar expresiones regulares en el estilo Perl.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE versi??n de librer??a: SuiteCRM necesita la versi??n 7.0 o superior de la librer??a PCRE para procesar expresiones regulares en el estilo Perl.',
	'ERR_DB_ADMIN'						=> 'El nombre de usuario o contrase??a del administrador de base de datos es inv??lido, y no se puede establecer la conexi??n con la base de datos. Por favor ingrese un nombre de usuario y contrase??a correctos. (Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'El nombre de usuario o contrase??a del administrador de base de datos es inv??lido, y no se puede establecer la conexi??n con la base de datos. Por favor ingrese un nombre de usuario y contrase??a correctos.',

	'ERR_DB_EXISTS_NOT'					=> 'La base de datos especificada no existe.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'La base de datos ya existe con informaci??n de configuraci??n. Para ejecutar una instalaci??n con la base de datos seleccionada vuelva a ejecutar la instalaci??n y seleccione "Eliminar las tablas existentes y volver a crearlas?". Para actualizar utilice el Asistente de Actualizaciones en la Consola de Administraci??n. Por favor lea la documentaci??n de actualizaci??n <a href="http://www.suitecrm.com target="_new">aqu??</a>',
	'ERR_DB_EXISTS'						=> 'Ya existe una Base de Datos con el nombre provisto -- no se puede crear otra con el mismo nombre.',
	// hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
    'ERR_DB_EXISTS_PROCEED'             => 'Ya existe una Base de Datos con el nombre provisto.  Usted puede<br>1.  presionar el bot??n Atr??s y seleccionar un nuevo nombre de base de datos <br>2.  hacer click en Siguiente y continuar, aunque todas las tablas existentes en esta base de datos ser??n descartadas.  <strong>Esto significa que sus tablas e informaci??n ser??n eliminadas </strong>',
	'ERR_DB_HOSTNAME'					=> 'El nombre de Host no puede ser vac??o.',
	'ERR_DB_INVALID'					=> 'Tipo de base de datos seleccionado no v??lido.',
	'ERR_DB_LOGIN_FAILURE'				=> 'El host, nombre de usuario y/o contrase??a provistos no es v??lido, y no se puede establecer una conexi??n a la base de datos. Por favor ingrese un host, nombre de usuario y contrase??a v??lidos.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'El host, nombre de usuario y/o contrase??a provistos no es v??lido, y no se puede establecer una conexi??n a la base de datos. Por favor ingrese un host, nombre de usuario y contrase??a v??lidos.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'El host, nombre de usuario y/o contrase??a provistos no es v??lido, y no se puede establecer una conexi??n a la base de datos. Por favor ingrese un host, nombre de usuario y contrase??a v??lidos.',
	'ERR_DB_MYSQL_VERSION'				=> 'Su versi??n de MySQL (%s) no es soportada por SuiteCRM.  Deber?? instalar una versi??n que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de Versi??n para conocer las versiones soportadas.',
	'ERR_DB_NAME'						=> 'El nombre de base de datos no puede estar vac??o.',
	'ERR_DB_NAME2'						=> "El nombre de base de datos no puede contener '\\', '/', o '.'",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede contener '\\', '/', o '.'",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede comenzar con un n??mero, '#', o '@' y no puede contener espacios, '\"', \"'\", '*', '/', '\', '?', ':', '<', '>', '&', '!', o '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "El nombre de base de datos s??lo puede estar formado por caracteres alfanum??ricos y los s??mbolos '#', '_' o '$'",
	'ERR_DB_PASSWORD'					=> 'Las contrase??as provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contrase??as en los campos.',
	'ERR_DB_PRIV_USER'					=> 'Provea un nombre de usuario administrador de base de datos.  El usuario es requerido para la conexi??n inicial a la base de datos.',
	'ERR_DB_USER_EXISTS'				=> 'El nombre de usuario para la base de datos ya existe -- no se puede crear otro con el mismo nombre. Por favor ingrese un nuevo nombre de usuario.',
	'ERR_DB_USER'						=> 'Ingrese un nombre de usuario para el administrador de base de datos.',
	'ERR_DBCONF_VALIDATION'				=> 'Por favor corrija los siguientes errores antes de continuar:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Las contrase??as provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contrase??as en los campos.',
	'ERR_ERROR_GENERAL'					=> 'Se encontraron los siguientes errores:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'No se puede eliminar el archivo: ',
	'ERR_LANG_MISSING_FILE'				=> 'No se encuentra el archivo: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No se encontr?? archivo de traducci??n en include/language dentro de: ',
	'ERR_LANG_UPLOAD_1'					=> 'Hubo un problema con su upload.  Por favor vuelva a intentarlo.',
	'ERR_LANG_UPLOAD_2'					=> 'Los paquetes de idioma deben ser archivos ZIP.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP no pudo mover el archivo temporal a la carpeta upgrade.',
	'ERR_LICENSE_MISSING'				=> 'Faltan Campos Obligatorios',
	'ERR_LICENSE_NOT_FOUND'				=> 'No se encontr?? la licencia!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'El directorio de Log provisto no es un directorio v??lido.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'El directorio de Log provisto no tiene permisos de escritura.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Se requiere un directorio de Log si usted desea especificar uno.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'No se puede procesar el script de forma directa.',
	'ERR_NO_SINGLE_QUOTE'				=> 'No se puede usar comillas simples para ',
	'ERR_PASSWORD_MISMATCH'				=> 'Las contrase??as provistas para el usuario admin de SuiteCRM no coinciden.  Por favor vuelva a ingresar las mismas contrase??as en los campos.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'No se puede escribir el archivo <span class=stop>config.php</span>.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Puedecontinuar con esta instalaci??n creando manualmente el archivo config.php y pegando la siguiente informaci??n de configuraci??n dentro del archivo.  De todos modos, usted <strong>deber??a </strong>crear el archivo config.php antes de continuar con el siguiente paso.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Se acord?? de crear el archivo config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Advertencia: No se pudo escribir el archivo config.php.  Aseg??rese de que existe.',
	'ERR_PERFORM_HTACCESS_1'			=> 'No es puede escribir el archivo ',
	'ERR_PERFORM_HTACCESS_2'			=> ' .',
	'ERR_PERFORM_HTACCESS_3'			=> 'Si desea proteger su archivo de log de ser accedido via navegador, cree un archivo .htaccess en su carpeta log con la l??nea:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>No hemos podido detectar una conexi??n a Internet.</b> Cuando tenga una conexi??n, por favor visite <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> para registrarse con SuiteCRM. Si nos cuenta un poco c??mo su compa????a planea utilizar SuiteCRM podremos asegurarnos de entregarle la aplicaci??n correcta para las necesidades de su negocio.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'El directorio de Sesi??n provisto no es un directorio v??lido.',
	'ERR_SESSION_DIRECTORY'				=> 'El directorio de Sesi??n provisto no tiene permisos de escritura.',
	'ERR_SESSION_PATH'					=> 'Se requiere una ruta de Sesi??n, si es que desea especificar una.',
	'ERR_SI_NO_CONFIG'					=> 'No incluy?? el archivo config_si.php en el directorio ra??z, o no defini?? la variable $sugar_config_si en config.php',
	'ERR_SITE_GUID'						=> 'Se requiere un ID de Aplicaci??n si es que desea especificar uno.',
    'ERROR_SPRITE_SUPPORT'              => "No hemos podido encontrar la librer??a GD, como resultado no podr?? utilizar la funcionalidad CSS Sprite.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Advertencia: Debe cambiar su configuraci??n de PHP para permitir la subida de archivos de al menos 6MB.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Tama??o de Subida de Archivos',
	'ERR_URL_BLANK'						=> 'Provea la URL base para su instancia de SuiteCRM.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'No se pudo encontrar el registro de instalaci??n de ',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'El archivo subido no es compatible con esta edici??n (Community Edition, Professional, o Enterprise) de SuiteCRM: ',
	'ERROR_LICENSE_EXPIRED'				=> "Error: Su licencia expir?? hace ",
	//																																																			                                If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_LICENSE_EXPIRED2'			=> " d??a(s).   Por favor visite el <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administrador de Licencias\"</a>  en la pantalla de administrador para ingresar la nueva Clave.  Si no ingresa una nueva clave de licencia dentro de los 30 d??as de expirada, ya no se le permitir?? ingresar en la aplicaci??n. ",
	'ERROR_MANIFEST_TYPE'				=> 'El archivo Manifest debe especificar el tipo de paquete.',
	'ERROR_PACKAGE_TYPE'				=> 'El archivo Manifest especifica un tipo de paquete no reconocido',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Su licencia expir?? hace ",
	'ERROR_VALIDATION_EXPIRED2'			=> " d??a(s).   Por favor visite el <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administrador de Licencias\"</a>  en la pantalla de administrador para ingresar la nueva Clave.  Si no ingresa una nueva clave de licencia dentro de los 30 d??as de expirada, ya no se le permitir?? ingresar en la aplicaci??n. ",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'El archivo subido no es compatible con esta versi??n de SuiteCRM: ',

	'LBL_BACK'							=> 'Atr??s',
    'LBL_CANCEL'                        => 'Cancelar',
    'LBL_ACCEPT'                        => 'Acepto',
	'LBL_CHECKSYS_1'					=> 'Para que su instalaci??n de SuiteCRM funcione correctamente, por favor aseg??rese de que todos los items por verificar listados m??s abajo est??n en verde. Si encuentra alguno en rojo, por favor realice los pasos necesarios para solucionarlos.<BR><BR> Para obtener ayuda por estos items, visite <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Sub-Directories de Cache Editables',
	//'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned On',
    'LBL_DROP_DB_CONFIRM'               => 'El nombre de Base de Datos provisto ya existe. <br>Usted puede<br>1.  presionar el bot??n Atr??s y seleccionar un nuevo nombre de base de datos <br>2.  hacer click en Siguiente y continuar, aunque todas las tablas existentes en esta base de datos ser??n descartadas.  <strong>Esto significa que sus tablas e informaci??n ser??n eliminadas </strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference desactivado',
    'LBL_CHECKSYS_COMPONENT'			=> 'Componente',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Componentes Opcionales',
	'LBL_CHECKSYS_CONFIG'				=> 'Archivo de Configuraci??n editable (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Archivo de Configuraci??n editable (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'M??dulo cURL',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Ruta del Directorio de Sesi??n',
	'LBL_CHECKSYS_CUSTOM'				=> 'Directorio Custom editable',
	'LBL_CHECKSYS_DATA'					=> 'Subdirectorios de Data editables',
	'LBL_CHECKSYS_IMAP'					=> 'M??dulo IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'M??dulo MB Strings',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (Sin L??mite)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (Ilimitado)',
	'LBL_CHECKSYS_MEM'					=> 'L??mite de Memoria PHP',
	'LBL_CHECKSYS_MODULE'				=> 'Subdirectorios y Archivos de m??dulos editables',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Versi??n MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'No disponible',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'Ubicaci??n de su archivo de configuraci??n PHP (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'Versi??n de PHP',
    'LBL_CHECKSYS_IISVER'               => 'Versi??n de IIS',
    'LBL_CHECKSYS_FASTCGI'              => 'FastCGI',
	'LBL_CHECKSYS_RECHECK'				=> 'Volver a Verificar',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode desactivado',
	'LBL_CHECKSYS_SESSION'				=> 'Directorio de Sesi??n Editable (',
	'LBL_CHECKSYS_STATUS'				=> 'Estado',
	'LBL_CHECKSYS_TITLE'				=> 'Aceptaci??n de Verificaci??n del Sistema',
	'LBL_CHECKSYS_VER'					=> 'Encontrado: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'M??dulo de Compresi??n ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'M??dulo de manejo de ZIP',
	'LBL_CHECKSYS_PCRE'					=> 'Librer??a PCRE',
	'LBL_CHECKSYS_FIX_FILES'            => 'Por favor corrija los siguientes archivos o directorios antes de continuar:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Por favor corrija los siguientes directorios de m??dulos y archivos dentro de ellos antes de continuar:',
    'LBL_CHECKSYS_UPLOAD'               => 'Directorio Upload Editable',
    'LBL_CLOSE'							=> 'Cerrar',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'creada',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tipo de Base de Datos',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Por favor confirme la siguiente configuraci??n.  Se desea cambiar alguno de los valores, haga click en "Atr??s" para editar. De lo contrario haga click en "Siguiente" para comenzar la instalaci??n.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Informaci??n de la Licencia',
	'LBL_CONFIRM_NOT'					=> 'no',
	'LBL_CONFIRM_TITLE'					=> 'Confirmar configuraci??n',
	'LBL_CONFIRM_WILL'					=> 'ser??',
	'LBL_DBCONF_CREATE_DB'				=> 'Crear Base de Datos',
	'LBL_DBCONF_CREATE_USER'			=> 'Crear Usuario',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Atenci??n: Toda la informaci??n de SuiteCRM ser?? eliminada<br>si se marca esta casilla.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Eliminar las tablas existentes y volver a crearlas?',
    'LBL_DBCONF_DB_DROP'                => 'Eliminar Tablas',
    'LBL_DBCONF_DB_NAME'				=> 'Nombre de Base de Datos',




    
	'LBL_DBCONF_DB_PASSWORD'			=> 'Contrase??a del Usuario de Base de Datos',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Vuelva a Ingresar Contrase??a del Usuario de Base de Datos',
	'LBL_DBCONF_DB_USER'				=> 'Nombre de Usuario de Base de Datos',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'Nombre de Usuario de Base de Datos',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Nombre de Usuario del Administrador de Base de Datos',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Contrase??a del Administrador de Base de Datos',
	'LBL_DBCONF_DEMO_DATA'				=> 'Llenar la Base de Datos con Informaci??n de Prueba?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Seleccionar Informaci??n de Prueba',
	'LBL_DBCONF_HOST_NAME'				=> 'Nombre del Host',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Instancia del Host',
	'LBL_DBCONF_HOST_PORT'				=> 'Puerto',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Por favor ingrese la informaci??n de su configuraci??n a continuaci??n. Si no est?? seguro de lo que debe completar, le sugerimos que use los valores por defecto.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Usar texto multi-byte en la informaci??n de prueba?',
    'LBL_DBCONFIG_MSG2'                 => 'Nombre del Servidor Web o Equipo (Host) en la cual se encuentra la base de datos ( por ejemplo localhost o www.mydomain.com ):',
    'LBL_DBCONFIG_MSG3'                 => 'Nombre de la base de datos que contendr?? la informaci??n de la instancia de SuiteCRM que est?? a punto de instalar:',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
    'LBL_DBCONFIG_B_MSG1'               => 'Para configurar la base de datos de SuiteCRM es necesario el nombre de usuario y contrase??a de un administrador de base de datos que pueda crear las tablas, usuarios y escribir en ella.',
    'LBL_DBCONFIG_SECURITY'             => 'Por razones de seguridad, se puede especificar un usuario exclusivo para conectar a la base de datos de SuiteCRM. Este usuario debe ener permisos para escribir, modificar y recuperar informaci??n de la base de datos de SuiteCRM que ser?? creada para esta instancia. Este usuario puede ser el administrador de base de datos que se especific?? m??s arriba, usted puede proveer uno nuevo o uno existente.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Hazlo por mi',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Proveer usuario existente',
    'LBL_DBCONFIG_CREATE_DD'            => 'Definir un usuario que se crear??',
    'LBL_DBCONFIG_SAME_DD'              => 'El mismo que el Administrador',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'B??squeda Full-Text',
    'LBL_FTS_INSTALLED'                 => 'Instalado',
    'LBL_FTS_INSTALLED_ERR1'            => 'La caracter??stica de B??squeda Full-Text no est?? instalada.',
    'LBL_FTS_INSTALLED_ERR2'            => 'Usted puede realizar la instalaci??n, pero no podr?? utilizar la funcionalidad de B??squeda Full-Text. Por favor consulte la gu??a de instalaci??n de su servidor de base de datos para saber c??mo hacer esto, o contacte a su Administrador.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Contrase??a del usuario privilegiado de la Base de Datos',

	'LBL_DBCONF_PRIV_USER_2'			=> '??La cuenta de base de datos de arriba es de un Usuario Privilegiado?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Este usuario privilegiado de base de datos debe tener los permisos adecuados para crear una base de datos, eliminar/crear tablas, y crear un usuario. Este usuario privilegiado de base de datos s??lo ser?? utilizado para realizar las tareas necesarias durante el proceso de instalaci??n. Si este usuario tiene permisos suficientes, tambi??n puede utilizarlo como usuario de base de datos.',
	'LBL_DBCONF_PRIV_USER'				=> 'Nombre del Usuario Privilegiado de Base de Datos',
	'LBL_DBCONF_TITLE'					=> 'Configuraci??n de la Base de Datos',
    'LBL_DBCONF_TITLE_NAME'             => 'Provea un Nombre de Base de Datos',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Provea la informaci??n del usuario de la base de datos',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Despu??s de realizado este cambio, podr?? hacer click en el bot??n "Comenzar" de abajo para comenzar la instalaci??n. <i>Una vez finalizada la instalaci??n, puede cambiar el valor de \'installer_locked\' a \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'La instalaci??n ya se ejecut?? una vez. Como medida de seguridad se ha deshabilitado una segunda ejecuci??n. Si est?? absolutamente seguro de que quiere volver a ejecutarla, por favor vaya a su archivo config.php y encuentre (o agregue) una variable llamada \'installer_locked\' y col??quela en \'false\'. La l??nea deber??a quedar as??:',

	'LBL_DISABLED_HELP_1'				=> 'Para ayuda con la instalaci??n, por favor visite ',
    'LBL_DISABLED_HELP_LNK'               => 'http://www.suitecrm.com/forums/',
	'LBL_DISABLED_HELP_2'				=> 'foro de soporte de SuiteCRM',

	'LBL_DISABLED_TITLE_2'				=> 'La instalaci??n de SuiteCRM ha sido deshabilitada',
	'LBL_DISABLED_TITLE'				=> 'Instalaci??n de SuiteCRM Deshabilitada',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Juego de Caracteres comunmente usado en su zona',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Configuraci??n de Email Saliente',
    'LBL_EMAIL_CHARSET_CONF'            => 'Juego de Caracteres para el Email Saliente ',
	'LBL_HELP'							=> 'Ayuda',
    'LBL_INSTALL'                       => 'Instalar',
    'LBL_INSTALL_TYPE_TITLE'            => 'Opciones de Instalaci??n',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Seleccione el Tipo de Instalaci??n',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Instalaci??n T??pica</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Instalaci??n Personalizada</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'La clave es necesaria para la funcionalidad general de la aplicaci??n, pero no es necesaria para la instalaci??n. No es necesario que ingrese la clave ahora, pero deber?? proveerla despu??s de haber instalado la aplicaci??n.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requiere informaci??n m??nima para la instalaci??n. Recomendada para usuarios nuevos.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provee opciones adicionales a establecer durante la instalaci??n. La mayor parte de estas opciones tambi??n est??n disponibles despu??s de la instalaci??n en la pantalla de administraci??n. Recomendada para usuarios avanzados.',
	'LBL_LANG_1'						=> 'Para usar otro idioma diferente al idioma por defecto (US-English), puede subir e instalar un paquete de idioma en este momento. Tambi??n podr?? subir e instalar paquetes de idioma desde adentro de la aplicaci??n. Si quiere omitir este paso, haga click en Siguiente.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Instalar',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Quitar',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Desinstalar',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Subir',
	'LBL_LANG_NO_PACKS'					=> 'ninguno',



	'LBL_LANG_PACK_INSTALLED'			=> 'Se instalaron los siguientes paquetes de idioma: ',
	'LBL_LANG_PACK_READY'				=> 'Los siguientes paquetes de idioma est??n listos para ser instalados: ',
	'LBL_LANG_SUCCESS'					=> 'Se subi?? correctamente el paquete de idioma.',
	'LBL_LANG_TITLE'			   		=> 'Paquete de Idioma',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Instalando SuiteCRM.  Este proceso puede tomar unos minutos.',
	'LBL_LANG_UPLOAD'					=> 'Subir un Paquete de Idioma',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Aceptaci??n de Licencia',
    'LBL_LICENSE_CHECKING'              => 'Verificando la compatibilidad del sistema.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Verificando el entorno',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verificando las credenciales de BD.',
    'LBL_LICENSE_CHECK_PASSED'          => 'El sistema cumpli?? los requisitos.',
	'LBL_CREATE_CACHE' => 'Preparando para instalar...',
    'LBL_LICENSE_REDIRECT'              => 'Redireccionando en ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Si tiene la informaci??n de su licencia, por favor ingr??sela en los siguientes campos.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Ingresar Clave de Descarga',
	'LBL_LICENSE_EXPIRY'				=> 'Fecha de Vencimiento',
	'LBL_LICENSE_I_ACCEPT'				=> 'Acepto',
	'LBL_LICENSE_NUM_USERS'				=> 'Cantidad de Usuarios',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Por favor ingrese la cantidad de clientes offline adquiridos.',
	'LBL_LICENSE_OC_NUM'				=> 'Cantidad de Licencias de Clientes Offline',
	'LBL_LICENSE_OC'					=> 'Licencias de Clientes Offline',
	'LBL_LICENSE_PRINTABLE'				=> ' Versi??n Imprimible ',
    'LBL_PRINT_SUMM'                    => 'Imprimir Resumen',
	'LBL_LICENSE_TITLE_2'				=> 'Licencia SuiteCRM',
	'LBL_LICENSE_TITLE'					=> 'Informaci??n de Licencia',
	'LBL_LICENSE_USERS'					=> 'Licencias de Usuario',

	'LBL_LOCALE_CURRENCY'				=> 'Opciones de Moneda',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Moneda por Defecto',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'S??mbolo de Moneda',
	'LBL_LOCALE_CURR_ISO'				=> 'C??digo de Moneda(ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Separador de Miles',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separador Decimal',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Ejemplo',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'D??gitos Significativos',
	'LBL_LOCALE_DATEF'					=> 'Formato de Fecha por Defecto',
	'LBL_LOCALE_DESC'					=> 'La configuraci??n regional se ver?? reflejada globalmente en la instancia de SuiteCRM.',
	'LBL_LOCALE_EXPORT'					=> 'Juego de Caracteres para Importar/Exportar<br> <i>(Email, .csv, vCard, PDF, importaci??n de datos)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Delimitador para Exportaci??n (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Opciones de Importaci??n/Exportaci??n',
	'LBL_LOCALE_LANG'					=> 'Idioma por Defecto',
	'LBL_LOCALE_NAMEF'					=> 'Formato de Nombre por Defecto',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = saludo<br />f = nombre de pila<br />l = apellido',
	'LBL_LOCALE_NAME_FIRST'				=> 'David',
	'LBL_LOCALE_NAME_LAST'				=> 'Livingstone',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Formato de Hora por Defecto',
	'LBL_LOCALE_TITLE'					=> 'Configuraci??n Regional',
    'LBL_CUSTOMIZE_LOCALE'              => 'Personalizar Configuraci??n Regional',
	'LBL_LOCALE_UI'						=> 'Interfaz de Usuario',

	'LBL_ML_ACTION'						=> 'Acci??n',
	'LBL_ML_DESCRIPTION'				=> 'Descripci??n',
	'LBL_ML_INSTALLED'					=> 'Fecha de Instalaci??n',
	'LBL_ML_NAME'						=> 'Nombre',
	'LBL_ML_PUBLISHED'					=> 'Fecha de Publicaci??n',
	'LBL_ML_TYPE'						=> 'Tipo',
	'LBL_ML_UNINSTALLABLE'				=> 'Desinstalable',
	'LBL_ML_VERSION'					=> 'Version',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver para PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (extensi??n mysqli)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Siguiente',
	'LBL_NO'							=> 'No',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Estableciendo password de admin',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tabla de auditor??a / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Creando el archivo de configuraci??n de SuiteCRM',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Creando la base de datos</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>en</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Creando nombre de usuario y password de la Base de datos...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creando informaci??n por defecto de SuiteCRM',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creando nombre de usuario y password de base de datos para localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creando tablas de relaci??n para suiteCRM',
	'LBL_PERFORM_CREATING'				=> 'creando / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Creando reportes por defecto',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creando tareas planificadas por defecto',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Insertando configuraci??n por defecto',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Creando usuarios por defecto',
	'LBL_PERFORM_DEMO_DATA'				=> 'Llenando las tablas de la base de datos con Informaci??n de Prueba (esto puede tomar varios minutos)',
	'LBL_PERFORM_DONE'					=> 'listo<br>',
	'LBL_PERFORM_DROPPING'				=> 'eliminando / ',
	'LBL_PERFORM_FINISH'				=> 'Finalizar',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Actualizando la informaci??n de la licencia',
	'LBL_PERFORM_OUTRO_1'				=> 'La configuraci??n de SuiteCRM ',
	'LBL_PERFORM_OUTRO_2'				=> ' ha finalizado!',
	'LBL_PERFORM_OUTRO_3'				=> 'Tiempo total: ',
	'LBL_PERFORM_OUTRO_4'				=> ' segundos.',
	'LBL_PERFORM_OUTRO_5'				=> 'Memoria utilizada (aprox): ',
	'LBL_PERFORM_OUTRO_6'				=> ' bytes.',
	'LBL_PERFORM_OUTRO_7'				=> 'Su sistema ya est?? instalado y configurado para ser utilizado.',
	'LBL_PERFORM_REL_META'				=> 'metadatos de relaciones ... ',
	'LBL_PERFORM_SUCCESS'				=> '??xito!',
	'LBL_PERFORM_TABLES'				=> 'Creando las tablas de la aplicaci??n, tablas de auditor??a y metadatos de relaciones',
	'LBL_PERFORM_TITLE'					=> 'Configurar',
	'LBL_PRINT'							=> 'Imprimir',
	'LBL_REG_CONF_1'					=> 'Por favor complete el breve formulario a continuaci??n para recibir anuncios de productos, novedades de capacitaciones, ofertas especiales e invitaciones epeciales a eventos de SuiteCRM. No vendemos, alquilamos, compartimos ni distribuimos de ninguna forma la informaci??n recolectada aqu??.',
	'LBL_REG_CONF_2'					=> 'Su nombre y direcci??n de email son los ??nicos campos requeridos para la registraci??n. El resto de los campos son opcionales, pero de mucha ayuda. No vendemos, alquilamos, compartimos ni distribuimos de ninguna forma la informaci??n recolectada aqu??.',
	'LBL_REG_CONF_3'					=> 'Gracias por registrarse. Haga click en el bot??n Finalizar para ingresar a SuiteCRM. Necesitar?? ingresar por primera vez utilizando el nombre de usuario "admin" y la contrase??a que ingres?? en el paso 2.',
	'LBL_REG_TITLE'						=> 'Registraci??n',
    'LBL_REG_NO_THANKS'                 => 'No Gracias',
    'LBL_REG_SKIP_THIS_STEP'            => 'Omitir este Paso',
	'LBL_REQUIRED'						=> '* Campo Requerido',

    'LBL_SITECFG_ADMIN_Name'            => 'Nombre del Administrador de SuiteCRM',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Vuelva a Ingresar la Contrase??a del Usuario Administrador',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Atenci??n: Esto sobreescribir?? la contrase??a del administrador de cualquier instalaci??n anterior.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Contrase??a del Usuario Administrador',
	'LBL_SITECFG_APP_ID'				=> 'ID de la Aplicaci??n',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Si se selecciona, deber?? proveer un ID de Aplicaci??n para sobreescribir el ID autogenerado. El ID asegura que las sesiones de una instancia de SuiteCRM no sean usadas por otras instancia. Si tiene un cluster de instalaciones de SuiteCRM, todas deber??an compartir el mismo ID de aplicaci??n.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Provea su propio ID de Aplicaci??n',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Si se selecciona, deber?? especificar un directorio de logs para sobreescribir el directorio por defecto del log de SuiteCRM. Sin importar d??nde est?? ubicado el archivo de log, el acceso a trav??s de navegador se deber?? restringir utilizando una redirecci??n .htacces.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Utilizar un Directorio Personalizado para Logs',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Si se selecciona, deber?? proveer un directorio seguro para almacenar la informaci??n de sesiones de SuiteCRM. Esto se puede hacer para evitar que la informaci??n de la sesi??n sea vulnerada en servidores compartidos.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Utilizar un Directorio Personalizado para las Sesiones de SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Por favor ingrese la configuraci??n de su sitio a continuaci??n. Si no est?? seguro de los campos, le sugerimos utilizar los valores por defecto.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Por favor corrija los siguientes errores antes de continuar:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Directorio de Log',
	'LBL_SITECFG_SESSION_PATH'			=> 'Ruta del Directorio de Sesiones<br>(debe ser editable)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Seleccionar Opciones de Seguridad',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Si se selecciona, el sistema peri??dicamente verificar?? por actualizaciones de la aplicaci??n.',
	'LBL_SITECFG_SUGAR_UP'				=> '??Verificar Autom??ticamente nuevas Actualizaciones?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Configuraci??n de Actualizaciones de SuiteCRM',
	'LBL_SITECFG_TITLE'					=> 'Configuraci??n del Sitio',
    'LBL_SITECFG_TITLE2'                => 'Identificar el Usuario Administrador',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Seguridad del Sitio',
	'LBL_SITECFG_URL'					=> 'URL de la Instancia de SuiteCRM',
	'LBL_SITECFG_USE_DEFAULTS'			=> '??Utilizar valores por defecto?',
	'LBL_SITECFG_ANONSTATS'             => '??Enviar estad??sticas an??nimas de uso?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Si se selecciona, SuiteCRM enviar?? estad??sticas <b>an??nimas</b> acerca de su instalaci??n a SuiteCRM Inc. cada vez que su sistema verifique nuevas versiones. Esta informaci??n nos ayudar?? a mejorar nuestra comprensi??n de c??mo la aplicaci??n es utilizada, y guiar?? las mejoras del producto.',
    'LBL_SITECFG_URL_MSG'               => 'Ingrese la URL que ser?? utilizada para acceder a la instancia de SuiteCRM despu??s de la instalaci??n. La URL tambi??n va a ser utilizada como base para para las URL en las p??ginas de la aplicaci??n. La URL puede incluir el nombre del servidor web, nombre del equipo o direcci??n IP.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Ingrese un nombre para su sistema. El nombre se mostrar?? en la barra de t??tulo del navegador cuando los usuarios visiten la aplicaci??n SuiteCRM.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'Despu??s de la instalaci??n, necesitar?? utilizar el usuario administrador de SuiteCRM (nombre por defecto = admin) para ingresar a la instancia de SuiteCRM. Ingrese  una contrase??a para este usuario administrador. Esta contrase??a puede ser cambiada despu??s de ingresar por primera vez. Tambi??n puede ingresar otro nombre de usuario diferente al valor por defecto provisto.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Seleccione la configuraci??n de collation (ordenamiento de los datos) para su sistema. Esta configuraci??n crear?? las tablas con el idioma espec??fico que usted usa. En caso de que su idioma no requiera una configuraci??n especial, utilice el valor por defecto.',
    'LBL_SPRITE_SUPPORT'                => 'Soporte de Sprite',
	'LBL_SYSTEM_CREDS'                  => 'Credenciales del Sistema',
    'LBL_SYSTEM_ENV'                    => 'Entorno del Sistema',
	'LBL_START'							=> 'Comenzar',
    'LBL_SHOW_PASS'                     => 'Mostrar Contrase??as',
    'LBL_HIDE_PASS'                     => 'Ocultar Contrase??as',
    'LBL_HIDDEN'                        => '<i>(oculto)</i>',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>Seleccione su idioma</b>',
	'LBL_STEP'							=> 'Paso',
	'LBL_TITLE_WELCOME'					=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_1'						=> 'Este instalador crea las tablas de la base de datos de SuiteCRM y establece los valores de configuraci??n que ustede necesita para comenzar. El proceso completo deber??a tomar aproximadamente diez minutos.',
	'LBL_WELCOME_2'						=> 'Para obtener documentaci??n de la instalaci??n, por favor visite <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM</a>.  <BR><BR> Tambi??n podr?? encontrar ayuda de la Comunidad de SuiteCRM en los <a href="http://www.SuiteCRM.com/" target="_blank">Foros de SuiteCRM</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Est?? listo para instalar?',
    'REQUIRED_SYS_COMP' => 'Componentes de Sistema Requeridos',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Antes de comenzar, por favor aseg??rese de que tiene las versiones soportadas de los siguientes componentes del sistema:<br>
                      <ul>
                      <li> Base de Datos/Sistema Manejador de Base de Datos (Ejemplos: MariaDB, MySQL or SQL Server)</li>
                      <li> Servidor Web (Apache, IIS)</li>
                      </ul>
                      Consulte la Matriz de Compatibilidad en las Notas de la Versi??n para encontrar
                      componentes de sistema compatibles para la versi??n de SuiteCRM que est?? instalando<br>',
    'REQUIRED_SYS_CHK' => 'Chequeo Inicial del Sistema',
    'REQUIRED_SYS_CHK_MSG' =>
                    'Al comenzar el proceso de instalacion, se realizar?? un chequeo de sistema en el servidor web en el cual est??n ubicados los archivos de SuiteCRM con el objetivo de asegurar que el sistema est?? correctamente configurado y que tiene todos los componentes necesarios para completar la instalaci??n exitosamente. <br><br>
                      El sistema chequea todo lo siguiente:<br>
                      <ul>
                      <li><b>Versi??n de PHP</b> &#8211; debe ser compatible con la aplicaci??n</li>
                                        <li><b>Variables de Sesi??n</b> &#8211; deben funcionar correctamente</li>
                                            <li> <b>MB Strings</b> &#8211; debe estar instalada y habilitada en php.ini</li>

                      <li> <b>Soporte de Base de Datos</b> &#8211; debe existir para MariaDB, MySQL o SQL Server</li>

                      <li> <b>Config.php</b> &#8211; debe existir y debe tener los permisos apropiados para ser editable</li>
					  <li>Los siguientes archivos de SuiteCRM deben ser editables:<ul><li><b>/custom</li>
<li>/cache</li>
<li>/modules</li>
<li>/upload</b></li></ul></li></ul>
                                  Si la verificaci??n falla, no podr?? continuar con la instalaci??n. Se le mostrar?? un mensaje de error, explicando por qu?? su sistema no pas?? la verificaci??n.
                                  Despu??s de hacer los cambios necesarios, podr?? realizar nuevamente la verificaci??n del sistema para continuar con la instalaci??n.<br>',
    'REQUIRED_INSTALLTYPE' => 'Instalaci??n T??pica o Personalizada',
    'REQUIRED_INSTALLTYPE_MSG' =>
                    'Despu??s de realizado el chequeo del sistema, puede seleccionar entre instalaci??n T??pica o Personalizada..<br><br>
                      Para ambas <b>T??pica</b> y <b>Personalizada</b>, necesitar?? saber lo siguiente:<br>
                      <ul>
                      <li> <b>Tipo de Base de Datos</b> que albergar?? la informaci??n de SuiteCRM <ul><li>Tipos de Base de Datos Compatibles: MariaDB, MySQL o SQL Server.<br><br></li></ul></li>
                      <li> <b>Nombre del servidor web</b> o equipo (host) en el cual se encuentra la base de datos
                      <ul><li>Puede ser <i>localhost</i> si la base de datos se encuentra en su equipo local, o en el mismo servidor web o equipo que los archivos de SuiteCRM.<br><br></li></ul></li>
                      <li><b>Nombre de la base de datos</b> que desea utilizar para albergar la informaci??n de SuiteCRM</li>
                        <ul>
                          <li> Quiz??s usted ya tenga una base de datos existente que desear??a utilizar. Si usted provee el nombre de una base de datos existente, se eliminar??n las tablas existentes de la base de datos durante la instalaci??n cuando se defina el nuevo esquema para la base de datos de SuiteCRM.</li>
                          <li> Si todav??a no posee una base de datos, el nombre que usted provea ser?? utilizado durante la instalaci??n para la nueva base de datos que sea creada para la instancia..<br><br></li>
                        </ul>
                      <li><b>Nombre y contrase??a del administrador de la base de datos</b> <ul><li>El administrador de baes de datos deber??a tener permisos para crear tablas, usuarios y escribir en la base de datos.</li><li>Puede que sea necesario contactar a su administrador de base de datos para que le provea esta informaci??n si la base de datos no se encuentra en su equipo local y/o si usted no es el administrador de base de datos.<br><br></ul></li></li>
                      <li> <b>Nombre de usuario de base de datos y contrase??a</b>
                      </li>
                        <ul>
                          <li> El usuario puede ser el administrador de la base de datos, o puede proveer el nombre de otro usuario existente de la base de datos. </li>
                          <li> Si desea crear un nuevo usuario de base de datos para este prop??sito, deber?? proveer un nuevo nombre de usuario y contrase??a, y el usuario ser?? creado durante la instalaci??n. </li>
                        </ul></ul><p>

                      Para la configuraci??n <b>Personalizada</b>, tambi??n deber?? saber lo siguiente:<br>
                      <ul>
                      <li> <b>URL que ser?? utilizada para acceder a la instancia de SugarCRM</b> despu??s de ser instalada.
                      Esta URL puede incluir el nombre o direcci??n IP del servidor o equipo.<br><br></li>
                                  <li> [Opcional] <b>Ruta del directorio de sesi??n</b> si desea utilizar un directorio personalizado para la informaci??n de SuiteCRM con el objetivo de evitar vulnerabilidad en servidores compartidos.<br><br></li>
                                  <li> [Opcional] <b>Ruta personalizada del directorio de log</b> si desea sobreescribir el directorio por defecto utilizado para los archivos de log de SuiteCRM.<br><br></li>
                                  <li> [Opcional] <b>ID de Aplicaci??n</b> si desea sobreescribir el ID autogenerado para garantizar que las sesiones de una instancia de SuiteCRM no son utilizadas por otras instancias.<br><br></li>
                                  <li><b>Set de Caracteres</b> comunmente utilizado seg??n su zona.<br><br></li></ul>
                                  Para obtener informaci??n m??s detallada, por favor consulte la Gu??a de Instalaci??n.
                                ',

    'LBL_WELCOME_PLEASE_READ_BELOW' => 'Por favor lea la siguiente informaci??n importante antes de continuar con la instalaci??n . La informaci??n le ayudar?? a determinar si est?? listo o no para instalar la aplicaci??n en este momento.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Seleccione su idioma</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Asistente de Configuraci??n',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_TITLE'					=> 'Asistente de Configuraci??n de SuiteCRM',
	'LBL_WIZARD_TITLE'					=> 'Asistente de Configuraci??n de SuiteCRM: ',
	'LBL_YES'							=> 'S??',
    'LBL_YES_MULTI'                     => 'S?? - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Procesar Tareas de Workflow',
	'LBL_OOTB_REPORTS'		=> 'Ejecutar Generaci??n de Reportes Planificados',
	'LBL_OOTB_IE'			=> 'Verificar el Correo Entrante',
	'LBL_OOTB_BOUNCE'		=> 'Procesar Rebotes de Emails de Campa??as',
    'LBL_OOTB_CAMPAIGN'		=> 'Procesar Emails de Campa??as',
	'LBL_OOTB_PRUNE'		=> 'Limpiar la Base de Datos el 1er d??a del Mes',
    'LBL_OOTB_TRACKER'		=> 'Limpiar las Tablas de Seguimiento',
    'LBL_OOTB_SUGARFEEDS'   => 'Limpiar las Tablas de SuiteCRM Feed',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Ejecutar Notificaciones de Recordatorios por Email',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Actualizar la Tabla tracker_sessions',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Limpiar Cola de Tareas',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Quitar Documentos del Filesystem',


    'LBL_PATCHES_TITLE'     => 'Instalar los Ultimos Parches',
    'LBL_MODULE_TITLE'      => 'Instalar Paquetes de Idioma',
    'LBL_PATCH_1'           => 'Si desea omitir este paso, haga click en Siguiente.',
    'LBL_PATCH_TITLE'       => 'Parche del Sistema',
    'LBL_PATCH_READY'       => 'Los siguientes parches est??n listos para ser instalados:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM depende de las Sesiones de PHP para almacenar informaci??n importante mientras se conecta al servidor web. Su instalaci??n de PHP no tiene la informaci??n de Sesiones correctamente configurada. 
	<br><br>Un problema com??n de configuraci??n es que la directiva <b>'session.save_path'</b> no est?? se??alando un directorio v??lido. <br>
	<br> Por favor corrija su <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>configuraci??n PHP</a> en el archivo php.ini ubicado a continuaci??n.",
	'LBL_SESSION_ERR_TITLE'				=> 'Error de Configuraci??n de Sesiones PHP',
	'LBL_SYSTEM_NAME'=>'Nombre del Sistema',
    'LBL_COLLATION' => 'Configuraci??n de Collation',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provea un Nombre de Sistema para su instancia SuiteCRM.',
	'LBL_PATCH_UPLOAD' => 'Seleccione un archivo de parche de su equipo local',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Se requiere Php versi??n 5 o superior.',
	'LBL_MINIMUM_PHP_VERSION' => 'La versi??n m??nima de PHP requerida es 5.1.0. La versi??n recomendada es 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Su versi??n actual es ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' La versi??n recomendada es 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'El modo Compatibilidad con versiones anteriores de PHP est?? activado. Establezca zend.ze1_compatibility_mode en Off para poder continuar.',

    'advanced_password_new_account_email' => array(
        'subject' => 'Informaci??n de la Nueva Cuenta de Usuario',
        'description' => 'Esta plantilla es utilizada cuando un Administrador de Sistema env??a una nueva contrase??a a un usuario.',
        'body' => '<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width="550" align=\"\&quot;\&quot;center\&quot;\&quot;\"><tbody><tr><td colspan=\"2\"><p>Aqu?? est?? su nuevo nombre de usuario y contrase??a temporal:</p><p>Nombre de Usuario : $contact_user_user_name </p><p>Contrase??a : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>Despu??s de ingresar utilizando la contrase??a de arriba, puede que se le pida cambiar la contrase??a por una de su propia elecci??n.</p>   </td>         </tr><tr><td colspan=\"2\"></td>         </tr> </tbody></table> </div>',
        'txt_body' =>
'
Aqu?? est?? su nuevo nombre de usuario y contrase??a temporal:
Nombre de Usuario : $contact_user_user_name
Contrase??a : $contact_user_user_hash

$config_site_url

Despu??s de ingresar utilizando la contrase??a de arriba, puede que se le pida cambiar la contrase??a por una de su propia elecci??n.',
        'name' => 'Email de contrase??a generada por el sistema',
        ),
    'advanced_password_forgot_password_email' => array(
        'subject' => 'Reestablecer su contrase??a',
        'description' => "Esta plantilla es utilizada para enviarle un enlace al usuario que al cliquearse reestablece la contrase??a de la cuenta del usuario.",
        'body' => '<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width="550" align=\"\&quot;\&quot;center\&quot;\&quot;\"><tbody><tr><td colspan=\"2\"><p>Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contrase??a de su cuenta. </p><p>Haga click en el siguiente enlace para reestablecer su contrase??a:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\"2\"></td>         </tr> </tbody></table> </div>',
        'txt_body' =>
'
Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contrase??a de su cuenta.

Haga click en el siguiente enlace para reestablecer su contrase??a:

$contact_user_link_guid',
        'name' => 'Email de Contrase??a Olvidada',
        ),
);

?>
