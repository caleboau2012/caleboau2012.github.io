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
  'LBL_MODULE_NAME' => 'Ventas',
  'LBL_MODULE_TITLE' => 'Ventas: Inicio',
  'LBL_SEARCH_FORM_TITLE' => 'B??squeda de Ventas',
  'LBL_VIEW_FORM_TITLE' => 'Vista de Ventas',
  'LBL_LIST_FORM_TITLE' => 'Lista de Ventas',
  'LBL_SALE_NAME' => 'Nombre de Venta:',
  'LBL_SALE' => 'Venta:',
  'LBL_NAME' => 'Nombre de Venta',
  'LBL_LIST_SALE_NAME' => 'Nombre',
  'LBL_LIST_ACCOUNT_NAME' => 'Nombre de Cuenta',
  'LBL_LIST_AMOUNT' => 'Cantidad',
  'LBL_LIST_DATE_CLOSED' => 'Cierre',
  'LBL_LIST_SALE_STAGE' => 'Etapa de Ventas',
  'LBL_ACCOUNT_ID' => 'ID de Cuenta',
  'LBL_CURRENCY_ID' => 'ID de Moneda',
  'db_sales_stage' => NULL,
  'db_name' => NULL,
  'db_amount' => NULL,
  'db_date_closed' => NULL,
  'UPDATE' => 'Venta - Actualizaci??n de Moneda',
  'UPDATE_DOLLARAMOUNTS' => 'Actualizar Cantidades en D??lares EEUU',
  'UPDATE_VERIFY' => 'Verificar Cantidades',
  'UPDATE_VERIFY_TXT' => 'Verifica que los valores de las cantidades en las ventas son n??meros decimales v??lidos con s??lo caracteres num??ricos (0-9) y decimales(.)',
  'UPDATE_FIX' => 'Corregir Cantidades',
  'UPDATE_FIX_TXT' => 'Intenta corregir cualquier cantidad no v??lida creando un n??mero decimal v??lido a partir de la cantidad actual. Antes realiza una copia de seguridad de todas las cantidades modificadas en el campo de base de datos amount_backup. Si tras la correci??n detecta problemas, no vuelva a realizar esta operaci??n sin restaurar los valores previos desde la copia de seguridad ya que si no sobrescribir?? la copia de seguridad con nuevos datos no v??lidos.',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualiza las cantidades en D??lares EEUU para las ventas basadas en el conjunto actual de cambios de moneda. Este valor se usa para calcular gr??ficas y vistas de listas de cantidades monetarias.',
  'UPDATE_CREATE_CURRENCY' => 'Creando Nueva Moneda:',
  'UPDATE_VERIFY_FAIL' => 'Fallo de Verificaci??n de Registro:',
  'UPDATE_VERIFY_CURAMOUNT' => 'Moneda Actual:',
  'UPDATE_VERIFY_FIX' => 'La Correcci??n dar??a',
  'UPDATE_INCLUDE_CLOSE' => 'Registros Cerrados Incluidos',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nueva Cantidad:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nueva Moneda:',
  'UPDATE_DONE' => 'Hecho',
  'UPDATE_BUG_COUNT' => 'Problemas Detectados cuya Resoluci??n se ha Intentado:',
  'UPDATE_BUGFOUND_COUNT' => 'Problemas Detectados:',
  'UPDATE_COUNT' => 'Registros Actualizados:',
  'UPDATE_RESTORE_COUNT' => 'Registros con Cantidades Restauradas:',
  'UPDATE_RESTORE' => 'Restaurar Cantidades',
  'UPDATE_RESTORE_TXT' => 'Restaura los valores de las cantidades desde la copia de seguridad creada durante la correcci??n.',
  'UPDATE_FAIL' => 'No ha podido actualizarse -',
  'UPDATE_NULL_VALUE' => 'La cantidad es NULL, estableci??ndola a 0 -',
  'UPDATE_MERGE' => 'Unificar Monedas',
  'UPDATE_MERGE_TXT' => 'Unifica m??ltiples monedas en una ??nica moneda. Si detecta que hay m??ltiples registros de tipo moneda para la misma moneda, puede unificarlas. Esto tambi??n unificar?? las monedas para el resto de m??dulos.',
  'LBL_ACCOUNT_NAME' => 'Nombre de Cuenta:',
  'LBL_AMOUNT' => 'Cantidad:',
  'LBL_AMOUNT_USDOLLAR' => 'Cantidad en D??lares EEUU:',
  'LBL_CURRENCY' => 'Moneda:',
  'LBL_DATE_CLOSED' => 'Fecha de Cierre Prevista:',
  'LBL_TYPE' => 'Tipo:',
  'LBL_CAMPAIGN' => 'Campa??a:',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_NEXT_STEP' => 'Pr??ximo Paso:',
  'LBL_LEAD_SOURCE' => 'Toma de Contacto:',
  'LBL_SALES_STAGE' => 'Etapa de Ventas:',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_DESCRIPTION' => 'Descripci??n:',
  'LBL_DUPLICATE' => 'Posible Venta Duplicada',
  'MSG_DUPLICATE' => 'El registro para la venta que va a crear podr??a ser un duplicado de otro registro de venta existente. Los registros de venta con nombres similares se listan a continuaci??n.<br>Haga clic en Guardar para continuar con la creaci??n de esta venta, o en Cancelar para volver al m??dulo sin crear la venta.',
  'LBL_NEW_FORM_TITLE' => 'Nueva Venta',
  'LNK_NEW_SALE' => 'Nueva Venta',
  'LNK_SALE_LIST' => 'Venta',
  'ERR_DELETE_RECORD' => 'Debe de especificar un n??mero de registro para eliminar la venta.',
  'LBL_TOP_SALES' => 'Mis Principales Ventas Abiertas',
  'NTC_REMOVE_OPP_CONFIRMATION' => '??Est?? seguro de que desea eliminar este contacto de la venta?',
  'SALE_REMOVE_PROJECT_CONFIRM' => '??Est?? seguro de que desea eliminar esta venta del proyecto?',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Venta',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_RAW_AMOUNT' => 'Importe Bruto',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_ASSIGNED_TO_NAME' => 'Usuario:',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_MY_CLOSED_SALES' => 'Mis Ventas Cerradas',
  'LBL_TOTAL_SALES' => 'Ventas Totales',
  'LBL_CLOSED_WON_SALES' => 'Ventas Ganadas',
  'LBL_ASSIGNED_TO_ID' => 'Asignada a ID',
  'LBL_CREATED_ID' => 'Creada por ID',
  'LBL_MODIFIED_ID' => 'Modificada por ID',
  'LBL_MODIFIED_NAME' => 'Modificada por Usuario',
  'LBL_SALE_INFORMATION' => 'Informaci??n sobre la Venta',
  'LBL_CURRENCY_NAME' => 'Nombre de Moneda',
  'LBL_CURRENCY_SYMBOL' => 'S??mbolo de Moneda',
  'LBL_EDIT_BUTTON' => 'Editar',
  'LBL_REMOVE' => 'Quitar',
);