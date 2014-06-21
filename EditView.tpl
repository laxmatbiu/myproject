{php}
global $current_language; $app_list_strings = return_app_list_strings_language($current_language);
global $db;

//Типы доп. услуги
//$this->assign('APP_LIST', $app_list_strings['service_type_dom']);
//$select_option_type = '';
//foreach ($app_list_strings['service_type_dom'] as $key=>$val)
//{
//  $select_option_type .= '<option value="' . $key . '">' . $val . '</option>';
//}

//Уровень контакта
//$this->assign('CONTACT_LEVEL', $app_list_strings['levelOfContactList']);
//$level_of_contact_list = '';
//foreach ($app_list_strings['levelOfContactList'] as $key=>$val)
//{
//  $level_of_contact_list .= '<option value="' . $key . '">' . $val . '</option>';
//}

//Расписание контакта

//$this->assign('CONTACT_SCHEDULE', $app_list_strings['scheduleOfContactList']);
//$schedule_of_contact_list = '';
//foreach ($app_list_strings['scheduleOfContactList'] as $key=>$val)
//{
//  $schedule_of_contact_list .= '<option value="' . $key . '">' . $val . '</option>';
//}

//Время
//$this->assign('CONTACT_TIME', $app_list_strings['time_h_m_dom']);
//$time_of_contact_list = '';
//foreach ($app_list_strings['time_h_m_dom'] as $key=>$val)
//{
//  $time_of_contact_list .= '<option value="' . $key . '">' . $val . '</option>';
//}

$additional_services = '';
$sql = "SELECT *
        FROM  fl_additionalservices
        WHERE parent_id = '{$_REQUEST['record']}'
        AND parent_type = '{$_REQUEST['module']}'
        AND deleted = 0
        ORDER BY name";
$result = $db->query($sql);
While ($row = $db->fetchByAssoc($result))
{
    if($additional_services=='')//    0 цена        1                        2                3                        4                        5 маржа             6
        $additional_services .= $row['name'].'^,^'.$row['id'].'^,^'.$row['account_id'].'^,^'.$row['marza'].'^,^'.$row['delivery'].'^,^'.$row['percent'].'^,^'.$row['formula'];
    else
        $additional_services .= '^|^'.$row['name'].'^,^'.$row['id'].'^,^'.$row['account_id'].'^,^'.$row['marza'].'^,^'.$row['delivery'].'^,^'.$row['percent'].'^,^'.$row['formula'];
}
$this->assign('services2',$additional_services);
{/php}

{assign var=services value="^|^"|explode:$services2}
{assign var=serviceCounter value=0}
{assign var=cur_count value=$services|@count }

<script type="text/javascript" language="javascript">
var cur_count = {$cur_count};
//alert (cur_count);
function {{sugarvar key='name'}}_sugarField()
{ldelim}
var {{sugarvar key='name'}} = '{{sugarvar key='name'}}';
return {{sugarvar key='name'}};
{rdelim}

$(document).ready(function()
{ldelim}

{rdelim}   );

function addServiceRow()
{ldelim}

	var table = document.getElementById("{$module}services");
	var rowCount = table.rows.length;
	var newRow = table.insertRow(rowCount);
	newRow.id = "{$module}serviceRow" + cur_count;
        newRow.name = "";

        var newTD2 = document.createElement('td');
	newTD2.align='center';
	newTD2.innerHTML = 'Поставщик: <input id="{$module}serviceFlag2_'+cur_count+'_name'+'" class="sqsEnabled yui-ac-input" type="text" autocomplete="off" title="" value="" size="" tabindex="0" name="{$module}serviceFlag2_'+cur_count+'_name'+'"><div id="{$form_name}_{$module}serviceFlag2_'+cur_count+'_name'+'_results" class="yui-ac-container"><div class="yui-ac-content" style="display: none;"><div class="yui-ac-hd" style="display: none;"></div><div class="yui-ac-bd"><ul><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li></ul></div><div class="yui-ac-ft" style="display: none;"></div></div></div><input id="{$module}serviceFlag2_'+cur_count+'_id'+'" type="hidden" value="" name="{$module}serviceFlag2_'+cur_count+'_id'+'"><span class="id-ff multiple">'+
        '<button id="btn_{$module}serviceFlag2_'+cur_count+'_name'+'" class="button firstChild" '+
        "onclick='open_popup( \"Accounts\", 600, 400, \"\", true, false, {ldelim}\"call_back_function\":\"set_return\",\"form_name\":\"{$form_name}\",\"field_to_name_array\":{ldelim}\"id\":\"{$module}serviceFlag2_"+cur_count+"_id"+"\",\"name\":\"{$module}serviceFlag2_"+cur_count+"_name"+"\"{rdelim}{rdelim}, \"single\", true );'" +
        'value="Select Account" title="Select Account" tabindex="0" name="btn_{$module}serviceFlag2_'+cur_count+'_name'+'" type="button">' +
        '<img src="themes/default/images/id-ff-select.png?v=5s17ehR1mirA_INbYT0UGQ"></button>'+'<button id="btn_clr_{$module}serviceFlag2_'+cur_count+'_name'+'" class="button lastChild" value="Clear Account" onclick="SUGAR.clearRelateField(this.form, \'{$module}serviceFlag2_'+cur_count+'_name'+'\', \'{$module}serviceFlag2_'+cur_count+'_id'+'\');" title="Clear Account" tabindex="0" name="btn_clr_{$module}serviceFlag2_'+cur_count+'_name'+'" type="button">'+
        '<img src="themes/default/images/id-ff-clear.png?v=5s17ehR1mirA_INbYT0UGQ"></button></span><scr' + 'ipt type=\'text/javascript\' defer=\'defer\'>' + 'var name = \'btn_{$module}serviceFlag2_'+cur_count+'_name\'; var button = document.getElementById(name); button.onblur = showIframe; function showIframe (){ldelim} var name = "{$module}serviceFlag2_'+cur_count+'_id"; var supl_id = document.getElementById(name); window.alert(supl_id) {rdelim}'+ '</scr' + 'ipt>';
   	newRow.appendChild (newTD2);





    var newTD0 = document.createElement('td');
    newTD0.innerHTML = 'Цена: <input type="text" name="{$module}serviceFlag0_'+cur_count+'" id="{$module}serviceFlag0_'+cur_count+'" size="10" value="">';
    newRow.appendChild (newTD0);

        var newTD4 = document.createElement('td');
        newTD4.innerHTML = 'Инвойс: <input type="text" name="{$module}serviceFlag4_'+cur_count+'" id="{$module}serviceFlag4_'+cur_count+'" size="10" value="">';
        newRow.appendChild (newTD4);

        var newTD5 = document.createElement('td');
        newTD5.innerHTML = 'Доставка: <input type="text" name="{$module}serviceFlag5_'+cur_count+'" id="{$module}serviceFlag5_'+cur_count+'" size="10" value="">';
        newRow.appendChild (newTD5);

    var newTD6 = document.createElement('td');
    newTD6.innerHTML = 'Маржа %: <input type="text" name="{$module}serviceFlag6_'+cur_count+'" id="{$module}serviceFlag6_'+cur_count+'" size="2" value="">';
    newRow.appendChild (newTD6);

    var newTD7 = document.createElement('td');
    newTD7.innerHTML ='<input type="text" name="{$module}serviceFlag7_'+cur_count+'" id="{$module}serviceFlag7_'+cur_count+'" size="5" value="" style="display: none">';
    newRow.appendChild (newTD7);

	var newTD9 = document.createElement('td');
	newTD9.innerHTML = '&nbsp;<img onclick="delServiceRow(\'{$module}serviceRow'+cur_count+'\')" id="{$module}removeButton0" class="id-ff-remove" name="0" src="{sugar_getimagepath file="id-ff-remove.png"}">';
	newRow.appendChild (newTD9);

        cur_count += 1;
{rdelim}


function delServiceRow(row_id)
{ldelim}
	var parent = document.getElementById(row_id).parentNode;
	parent.removeChild(document.getElementById(row_id))
{rdelim};


</script>

<span id="extservice">
<table style="border-spacing: 0pt;">
    <tr>
        <td valign="top" nowrap="">
            <table class="emailaddresses" id="{$module}services">
                <tr>
                    <td nowrap="" scope="row">
                        <span class="id-ff multiple ownline">
                            <button value="Добавить" onclick="javascript:addServiceRow()" type="button" class="button">
                                <img style="cursor:pointer;" src="{sugar_getimagepath file="id-ff-add.png"}">
                            </button>
                        </span>
                    </td>

                    <td scope="row" NOWRAP>
                        &nbsp;<!-- del button -->
                    </td>

                </tr>
                {foreach name=outer item=service from=$services}
                {assign var=item value="^,^"|explode:$service}
                <tr id="{$module}serviceRow{$serviceCounter}" name={$item.0}>
                    <!-- type 2 -->
                    <td align="center">
                       Поставщик: <input id="{$module}serviceFlag2_{$serviceCounter}_name" class="sqsEnabled yui-ac-input" type="text" autocomplete="off" title="" value="" size="" tabindex="0" name="{$module}serviceFlag2_{$serviceCounter}_name">
                        <div id="{$form_name}_{$module}serviceFlag2_{$serviceCounter}_name_results" class="yui-ac-container">
                            <div class="yui-ac-content" style="display: none;">
                                <div class="yui-ac-hd" style="display: none;"></div>
                                <div class="yui-ac-bd">
                                    <ul>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                        <li style="display: none;"></li>
                                    </ul>
                                </div>
                                <div class="yui-ac-ft" style="display: none;"></div>
                            </div>
                        </div>
                        <input id="{$module}serviceFlag2_{$serviceCounter}_id" type="hidden" value="{$item.2}" name="{$module}serviceFlag2_{$serviceCounter}_id">
<span class="id-ff multiple">
<button id="btn_{$module}serviceFlag2_{$serviceCounter}_name" class="button firstChild" onclick="open_popup( 'Accounts', 600, 400, '', true, false, {ldelim}'call_back_function':'set_return','form_name':'{$form_name}','field_to_name_array':{ldelim}'id':'{$module}serviceFlag2_{$serviceCounter}_id','name':'{$module}serviceFlag2_{$serviceCounter}_name'{rdelim}{rdelim}, 'single', true );" value="Select Account" title="Select Account" tabindex="0" name="btn_{$module}serviceFlag2_{$serviceCounter}_name" type="button">
<img src="themes/default/images/id-ff-select.png?v=_4764GItgVol4Tvh5JlF2Q">
    </button>
    <button id="btn_clr_{$module}serviceFlag2_{$serviceCounter}_name" class="button lastChild" value="Clear Account" onclick="SUGAR.clearRelateField(this.form, '{$module}serviceFlag2_{$serviceCounter}_name', '{$module}serviceFlag2_{$serviceCounter}_id');" title="Clear Account" tabindex="0" name="btn_clr_{$module}serviceFlag2_{$serviceCounter}_name" type="button">
        <img src="themes/default/images/id-ff-clear.png?v=_4764GItgVol4Tvh5JlF2Q">
    </button>
</span>
                        <script type="text/javascript">
                            var ids = document.getElementById('{$module}serviceFlag2_{$serviceCounter}_id');
                            var id = ids.value;
                            if (id != ''){ldelim}
                                var request = 'index.php?entryPoint=account_name&id=' + id;
                                var cObj = YAHOO.util.Connect.asyncRequest('POST',request, {ldelim}success: successGetForm{rdelim});
                                {rdelim}
                            function successGetForm(data)
                            {ldelim}
                                var response = data.responseText;
                                document.getElementById('{$module}serviceFlag2_{$serviceCounter}_name').value = response
                                {rdelim}
                        </script>
                    </td>
                    <!-- name 0 -->
                    <td nowrap="NOWRAP">
                       Цена: <input type="text" name="{$module}serviceFlag0_{$serviceCounter}" id="{$module}serviceFlag0_{$serviceCounter}" size="10" value="{$item.0}">
                    </td>
                                      <td nowrap="NOWRAP">
                                          Инвойс: <input type="text" name="{$module}serviceFlag4_{$serviceCounter}" id="{$module}serviceFlag4_{$serviceCounter}" size="10" value="{$item.3}">
                                       </td>
                                       <td nowrap="NOWRAP">
                                           Доставка: <input type="text" name="{$module}serviceFlag5_{$serviceCounter}" id="{$module}serviceFlag5_{$serviceCounter}" size="10" value="{$item.4}">
                                       </td>
                    <td nowrap="NOWRAP">
                        Маржа %: <input type="text" name="{$module}serviceFlag6_{$serviceCounter}" id="{$module}serviceFlag6_{$serviceCounter}" size="2" value="{$item.5}">
                    </td>
                    <td nowrap="NOWRAP">
                        <input type="text" name="{$module}serviceFlag7_{$serviceCounter}" id="{$module}serviceFlag7_{$serviceCounter}" size="5" value="{$item.6}" style="display: none">
                    </td>
                    <!-- del button -->
                    <td>
                        &nbsp;<img onclick="delServiceRow('{$module}serviceRow{$serviceCounter}')" id="{$module}removeButton0" class="id-ff-remove" name="0" style="cursor:pointer;" src="{sugar_getimagepath file="id-ff-remove.png"}">
                    </td>

                        <input type="hidden" name="{$module}serviceId_{$serviceCounter}" id="{$module}serviceId_{$serviceCounter}" value="{$item.1}">

                </tr>
                {assign var=serviceCounter value=$serviceCounter+1}
                {/foreach}
            </table>
        </td>
    </tr>
</table>
</span>