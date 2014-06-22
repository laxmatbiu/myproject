<?php
require_once('include/entryPoint.php');
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



$id = $_GET['id'];
$zakaz = $_GET['zakazid'];
if (!empty($zakaz)){
    $query1 = "select discount from drop_order where id ='{$zakaz}' and deleted = '0'";

    $res1=$GLOBALS['db']->query($query1);
    $res=$GLOBALS['db']->fetchByAssoc($res1);
    $disk= $res['discount'];
}else $disk = 0;

if (empty($disk)){
    $disk=0;
}


$qq = "select weight as ves from drop_tools where deleted ='0' and id = '{$id}'";

$r=$GLOBALS['db']->query($qq);
$r=$GLOBALS['db']->fetchByAssoc($r);


$ves = $r['ves'];
$kolvo = $_GET['kolvo'];
//$disk = $_GET['disk'];

if(empty($kolvo)){
    $kolvo=1;
}

if ($ves > 70){
    $tranz = $ves*$kolvo*3.5;
} else {
    $tranz = $ves*$kolvo*2.5;
}
/*
if (empty($disk)){
    $disk=0;
}
*/
$dost = $ves * $kolvo *1.5;

$file = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
$xml= simplexml_load_file($file); //Интерпретирует XML-документ в объект
$c = $xml->Cube;
$cube = $c->Cube;
$rr = $cube->Cube;
foreach ($rr as $cc){

if ($cc['currency']=='USD'){
    $usd =round(1/(float)$cc['rate'],3);
}
if ($cc['currency']=='GBP'){
    $gbp =round(1/(float)$cc['rate'],3);
}
}
global $current_user;
$role = new ACLRole;
$user_role = $role->getUserRoles($current_user->id);
$tt = '';
foreach ($user_role as $us){
    if ($us == 'Отдел продаж'){
        $tt = 'продацец';
    }
}
if ($tt == 'продацец'){
    echo 'У вас недостаточно прав для просмотра данной страницы';
}
else {

;

?>
<head>
    <link type="text/css" rel="stylesheet" href="custom/include/MVC/Controller/calc/css/css.css">
</head>
    <body style="background-color: aliceblue">
<input type="text" id="usd" value="<?php echo $usd?>" style="display: none">
<input type="text" id="gpb" value="<?php echo $gbp?>" style="display: none">
<table>

    <tr>
        <td>Валюта: </td>
        <td><select id="valuta" style="width: 100px">
                <option value="euro">Eвро</option>
                <option value="usd">Доллар</option>
                <option value="funt">Фунт</option>
        </select>
        </td>

    </tr>
<tr>
<td>Колличество: </td>
    <td><input type="text" name="count" id="count" value="<?php echo $kolvo?>"></td>

</tr>
    <tr>
        <td>Вес, кг: </td>
<td><input type="text" id="ves" name="ves" value="<?php echo $ves?>"></td>

    </tr>
<tr>
    <td>Цена по инвойсу: </td>
    <td><input type="text" id="price" value="">
    </td>

</tr>
    <tr>
        <td>Кросс-курс: </td>
        <td><input type="text" id="kurs" value="1">
        </td>

    </tr>
    <tr>
    <tr>
        <td>Скидка %: </td>
        <td><input type="text" id="disk" value="<?php echo $disk?>">
        </td>

    </tr>
        <td>Доставка: </td>
        <td><input type="text" id="dost" value="<?php echo $dost?>">
        </td>

    </tr>
    <tr>
        <td>Банковская комиссия: </td>
        <td><input type="text" id="bank" value="">
        </td>

    </tr>
    <tr>
        <td>Транзит : </td>
        <td><input type="text" id="tranzit" value="<?php echo $tranz?>">
        </td>

    </tr>
    <tr>
        <td>Промежуточная стоимость: </td>
        <td><input type="text" id="prom" value="">
        </td>

    </tr>
    <tr>
        <td>Маржа в %: </td>
        <td><input type="text" id="marz" value="18">
        </td>

    </tr>

    <tr><td></td><td><button type="submit" id="but" style="width: 100px">Считать</button></td></tr>

    </table>

<table>
    <tr><td>Итоговая цена:</td><td><input type="text" id="itogo" style="margin: 0 0 0 25px"></td></tr>

    <tr><td>Цена за единицу товара:</td><td><input type="text" id="ediniza" style="margin:  0 0 0 25px"><td><input type="button" id="peredat" value="Передать"></td></td></tr>

</table>
<script type="text/javascript">
function addToHtml (){
    var button = document.getElementById('but');
    var valuta = document.getElementById('valuta');
    var vess = document.getElementById('ves');
    valuta.onchange = cursValut;
    button.onclick = formula;
    vess.onchange = creanAll;

    function cursValut(){
        var usd = document.getElementById('usd').value;
        var gpb = document.getElementById('gpb').value;
        var kurs = document.getElementById('kurs');
        var valuta = document.getElementById('valuta');
        if (valuta.value == 'euro'){
            kurs.value = 1;
        } else if (valuta.value == 'usd'){
            kurs.value = parseFloat(usd)+0.02;
        } else {
            kurs.value = parseFloat(gpb)+0.02;
        }
    }

    function creanAll(){
        var tranzit = document.getElementById('tranzit');
        var dost = document.getElementById('dost');
        var promez = document.getElementById('prom')
        tranzit.value = 0;
        dost.value = 0;
        promez.value = 0;

    }

    function formula(){

        var count  = document.getElementById('count').value;
        var ves = document.getElementById('ves').value;
        var pricee = document.getElementById('price').value;
        var kurs = document.getElementById('kurs').value;
        var dost = document.getElementById('dost').value;
        var disk = document.getElementById('disk').value;
        var tranz = document.getElementById('tranzit').value;
        var diska = parseFloat(disk)/100;
        priceBez = document.getElementById('price').value;
        if (dost==0){
            dost=parseFloat(ves)*count*1.5
            document.getElementById('dost').value = dost
        }
        if (diska!=0){
            var price = pricee - pricee*diska
        }else {
            price = pricee
        }
        var bank = (parseFloat(price)+parseFloat(dost))*0.06
        barnkBez = (parseFloat(priceBez)+parseFloat(dost))*0.06
        document.getElementById('bank').value = bank;
        if (tranz ==0){
            if (parseFloat(ves)>70){
                tranz = parseFloat(ves)*count*3.5
            } else{
            tranz = parseFloat(ves)*count*2.5
            }
            document.getElementById('tranzit').value = tranz
        }

        var prom = price*count*parseFloat(kurs)+parseFloat(bank)+parseFloat(tranz)+ parseFloat(dost)
        promBez = priceBez*count*parseFloat(kurs)+parseFloat(barnkBez)+parseFloat(tranz)+ parseFloat(dost)
        document.getElementById('prom').value = prom;
        var marz = document.getElementById('marz').value;
            var itogo = parseFloat(prom)+parseFloat(prom)*marz/100
            itogoBez = parseFloat(promBez)+parseFloat(promBez)*marz/100
            document.getElementById('itogo').value = itogo.toFixed(3);
        var edin = itogo/count;
        document.getElementById('ediniza').value = edin.toFixed(3);
    }

    var peredat = document.getElementById('peredat');
    peredat.onclick = functionPeredat;
    function functionPeredat(){
        var count  = document.getElementById('count').value;
            var pricce =  itogoBez/count

        for (var i=0;i<15;i=i+1){
            var check = 'Drop_StorageserviceFlag0_'+i;
            if (window.parent.document.getElementById(check)){
                var h = i;
            }
        }

        var pric = 'Drop_StorageserviceFlag0_' + h;
        var invice = 'Drop_StorageserviceFlag4_'+h;
        var dostavka = 'Drop_StorageserviceFlag5_'+h;
        var cena =  document.getElementById('price').value;
        var marza = 'Drop_StorageserviceFlag6_'+h;
        var formula = 'Drop_StorageserviceFlag7_'+h;
        window.parent.document.getElementById(pric).value = pricce.toFixed(3);
        window.parent.document.getElementById(invice).value = document.getElementById('price').value;
        window.parent.document.getElementById(dostavka).value = document.getElementById('dost').value
        window.parent.document.getElementById(marza).value = document.getElementById('marz').value
        window.parent.document.getElementById(formula).value = 'Финляндия';


        window.parent.document.getElementById('invoice').value = document.getElementById('price').value;
        window.parent.document.getElementById('price').value = document.getElementById('ediniza').value;
        window.parent.document.getElementById('closeframe').click();
    }
}
 addToHtml ()
</script>
</body>
<?php }?>