<?php

$id = $_GET['id'];

global $current_user;
$role = new ACLRole;
$user_role = $role->getUserRoles($current_user->id);
$tt = '';
foreach ($user_role as $us){
    if ($us == '����� ������'){
        $tt = '��������';
    }
}
if ($tt == '��������'){
    echo '� ��� ������������ ���� ��� ��������� ������ ��������';
}
else {
    $query = "select drop_tools.name as tool,
    drop_tools.id as tool_id,
    drop_request.id as reqid,
    drop_storage.count as count,
    accounts.name as supl,
    drop_storage.id as id,
    fl_additionalservices.id as idd,
    fl_additionalservices.name as price,
    fl_additionalservices.marza as invoice,
    fl_additionalservices.delivery as dost,
    fl_additionalservices.formula as formula,
    fl_additionalservices.percent as marza
    from drop_storage
    left join drop_tools_drop_storage_1_c on drop_tools_drop_storage_1_c.drop_tools_drop_storage_1drop_storage_idb = drop_storage.id
    left join drop_tools on drop_tools_drop_storage_1_c.drop_tools_drop_storage_1drop_tools_ida = drop_tools.id
    left join fl_additionalservices on fl_additionalservices.parent_id = drop_storage.id
    left join accounts on fl_additionalservices.account_id = accounts.id
    left join drop_request_drop_storage_1_c on drop_request_drop_storage_1_c.drop_request_drop_storage_1drop_storage_idb = drop_storage.id
    left join drop_request on drop_request_drop_storage_1_c.drop_request_drop_storage_1drop_request_ida = drop_request.id

    where drop_storage.deleted = 0
    and drop_request_drop_storage_1_c.deleted = 0
    and drop_request_drop_storage_1_c.drop_request_drop_storage_1drop_request_ida = '{$id}'";
$res=$GLOBALS['db']->query($query);
    $get_number = "select drop_request.name as name,
    drop_buyer.discount as discount,
    drop_buyer.name as buyer_name
    from drop_request
    LEFT JOIN drop_buyer_drop_request_1_c ON drop_buyer_drop_request_1_c.drop_buyer_drop_request_1drop_request_idb = drop_request.id
    LEFT JOIN drop_buyer ON drop_buyer_drop_request_1_c.drop_buyer_drop_request_1drop_buyer_ida = drop_buyer.id
    where drop_request.id = '{$id}'";
    $r_req = $GLOBALS['db']->query($get_number);
    $row_req=$GLOBALS['db']->fetchByAssoc($r_req);
    ?>

    <h3 style="text-align: center; font-size: 14px">������ � <?php echo $row_req['name'];?></h3><br/>
    <h3 style="text-align: center; font-size: 14px">��������: <?php echo $row_req['buyer_name'];?>; ������: <span id="discount"><?php echo $row_req['discount']?></span>%</h3>

        <?php
    $storages = "select drop_tools.name as tool,
    drop_tools.id as tool_id,
    drop_storage.id as drop_id,
    drop_storage.count as count
    from drop_storage
    left join drop_tools_drop_storage_1_c on drop_tools_drop_storage_1_c.drop_tools_drop_storage_1drop_storage_idb = drop_storage.id
    left join drop_tools on drop_tools_drop_storage_1_c.drop_tools_drop_storage_1drop_tools_ida = drop_tools.id
    left join drop_request_drop_storage_1_c on drop_request_drop_storage_1_c.drop_request_drop_storage_1drop_storage_idb = drop_storage.id
    where drop_storage.deleted = 0
    and drop_request_drop_storage_1_c.drop_request_drop_storage_1drop_request_ida = '{$id}'
    and drop_request_drop_storage_1_c.deleted = 0
    order by tool";
        while($r=$GLOBALS['db']->fetchByAssoc($res)){
            $stor[] = $r;
        };
    $r_stor = $GLOBALS['db']->query($storages);
?>
    <head>
        <style type="text/css">
            td {
                height: 2px;
            }
            .thVal {
                width: 5px;
            }
        </style>
    </head>
    <form>
    <table border="1px solid" style="margin: auto; font-size: 14px">

    <tr style="border: 1px solid">
        <th style="border: 1px solid">��������</th>
        <th style="border: 1px solid">����������</th>
        <th style="border: 1px solid">���������</th>
        <th style="border: 1px solid">���� ��� ������</th>
        <th style="border: 1px solid">���� �� �������</th>
        <th style="border: 1px solid">��������� ��������</th>
        <th style="border: 1px solid">����� %</th>
        <th style="border: 1px solid">�������</th>
        <th style="border: 1px solid">������ � ����� ����������</th>

    </tr><?php
         $j=1;
    while ($row_stor = $GLOBALS['db']->fetchByAssoc($r_stor)){ ?>


        <tr style="border: 1px solid">
            <td style="border: 1px solid"><?php echo $row_stor['tool'];?></td>
            <td style="border: 1px solid; text-align: center" id="count<?php echo $j?>"><?php echo $row_stor['count'];?></td>
        <?php

        $i=0;

            foreach ($stor as $st){

            if ($st['tool_id']==$row_stor['tool_id'] and $st['drop_id']==$row_stor['id']){
            if ($i!=0){?>
              <td></td><td></td>
           <?php }
            ?>

            <td style="border: 1px solid"><?php echo $st['supl'];?></td>
            <td style="border: 1px solid; text-align: center" id="price<?php echo $i.'|'.$j?>"><?php echo $st['price'];?></td>
            <td style="border: 1px solid; text-align: center"><?php echo $st['invoice'];?></td>
            <td style="border: 1px solid; text-align: center" class="edit"><?php echo $st['dost'];?></td>
            <td  name="<?php echo $i.'|'.$j?>" id="marz<?php echo $i.'|'.$j?>" style="border: 1px solid; text-align: center; top: 50%" class="marza"><?php echo $st['marza'];?></td>
            <td style="border: 1px solid; text-align: center"><?php echo $st['formula'];?></td>
            <td style="border: 1px solid"><input type="radio" name="<?php echo $j;?>" value="<?php echo $i.'|'.$j.'|'.$st['formula']?>" style="position: relative; float: left; left: 49%"></td>


        </tr>
        <?php
        $i=$i+1;
            }

            } ?>

<tr style="height: 10px"></tr>


        <span style="display: none"><input type="radio" value="" id="input<?php echo $j?>"></span>
        <?php
        $j++;
    }?>
    <tr>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>�����:</td><td style="text-align: center" id="itogo">0</td>

    </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><button type="submit" style="position: relative;float: left;left: 17%">�������� ��������</button></td></tr>

    </table>

    </form>
    <script type="text/javascript">
        $(function () {
            $(".marza").dblclick(function (e) {
                e.stopPropagation();
                var currentEle = $(e.target);
                var value = $(e.target).html();
                ggg = value;
                namb = $(e.target).attr('name');
                getPrice(namb)
                function getPrice (namr){
                    var price = document.getElementById('price'+namr).innerHTML;
                    var marzaOld = document.getElementById('marz'+namr).innerHTML;
                    var k = 1+parseFloat(marzaOld)/100;
                    var beforemarza = price/k;
                    var someid = document.getElementById('beforemarza');
                    if (someid){
                        someid.innerHTML = beforemarza
                    }else{
                        var newSpan = document.createElement('span');
                        newSpan.id = "beforemarza";
                        newSpan.innerHTML = beforemarza;
                        newSpan.style.display = 'none';
                        document.body.appendChild(newSpan);
                    }

                    return true;
                }
                console.log($(e.target));

                if ($.trim(value) === "") {
                    $(currentEle).data('mode', 'add');
                } else {
                    $(currentEle).data('mode', 'edit');
                }
                updateVal(currentEle, value);
            }


            );
        });

        function updateVal(currentEle, value) {

            $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');

            var mode = $(currentEle).data('mode');
            $(".thVal").focus();
            $(".thVal").select();
            $(".thVal").keyup(function (event) {
                if (event.keyCode == 13) {
                    $(this).parent().html($(this).val().trim());
                    $(".thVal").remove();

                }

            });
        }



        $(document).click(function (e) {
            if ($(".thVal") !== undefined) {
                if ($(".thVal").val() !== undefined) {
                    $(".thVal").parent().html($(".thVal").val().trim());
                    $(".thVal").remove();
                    changePrice();
                }
            }
        });


        function changePrice(){
            var marza = document.getElementById('marz'+namb).innerHTML;
            var price = document.getElementById('price'+namb);
            var beforemarza = document.getElementById('beforemarza').innerHTML;
            price.innerHTML= (parseFloat(beforemarza)*(1+(parseFloat(marza)/100))).toFixed(3);
        }

    </script>

    <script>
        $(document).ready(function(){
            $("form").submit(function() {
                var submitme = true;
                $('input:radio').each(function() {
                    nam = $(this).attr('name');
                    if (submitme && !$(':radio[name="'+nam+'"]:checked').length) {
                        alert('�� ��� ���������� ��������');
                        submitme = false;
                    }
                });
                return submitme;
            });
            $('input:radio').mouseup(function(){
                var array = this.value.split('|');
                var itogo  = document.getElementById('itogo');
                var itog = itogo.innerHTML;
                var j = array[1];
                var hiden = document.getElementById('input'+j);
                var hidenArrey = hiden.value.split('|');
                if (hidenArrey[0]!=0 && hidenArrey[1]!=array[0]){
                itog = itog - hidenArrey[0];
                itogo.innerHTML = itog;
                }
            });
           $('input:radio').change(
                function(){
                    var array = this.value.split('|')
                    var i = array[0];
                    var j = array[1];
                    var formula = array[2];
                    var itogo  = document.getElementById('itogo');
                    var price = document.getElementById('price'+i);
                    var count = document.getElementById('count'+j);
                    var tt = count.innerHTML * price.innerHTML;
                    var hiden = document.getElementById('input'+j);
                    var tt = price.innerHTML * count.innerHTML
                    hiden.value = tt+'|'+i+'|'+j;
                    var itog = itogo.innerHTML
                    itog = parseFloat(itog) + price.innerHTML * count.innerHTML;
                    itogo.innerHTML=itog;

                }
            );
        });




       // $('input[name=1]:checked', '#myForm').val()
    </script>
<?php
}
        ?>





