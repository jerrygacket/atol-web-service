<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\web\View;

$this->title = 'ATOL PrintServer Demo';
?>
<div class="container-fluid">
    <div class="container">
        <div class="operatorInfo">
        </div>
        <div class="printersInfo">
            <h4>Выберете принтер из списка:</h4>
            <form>
                <div class="row">
                    <div class="col-md-4 col-12" id="connectInfo">
                        Принтеры:
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" id="FormPrinterSelect">
                            <option value="demo">Выберите</option>
                            <option value="demo">Любой</option>
                            <option value="demo">Принтер</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <button id="printConnect" class="btn btn-info col-md" type="submit">Подключиться к принтеру</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>Смена: <span id="shiftStatus"></span></h3>
            </div>
            <div class="col-md-6 col-12">
                <div id="buttons">
                    <button id="printOpenShift" class="btn btn-info col-md" type="submit">Открыть смену</button><br><br>
                    <button id="printCloseShift" class="btn btn-info col-md" type="submit">Закрыть смену</button><br><br>
                </div>
            </div>
        </div>
        <hr>
        <section id="printing" style="margin-bottom:80px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Все товары</h2>
                        <select size="9" id="allGoods" multiple>
                            <option value="1">Товар 1</option>
                            <option value="2">Товар 2</option>
                            <option value="3">Товар 3</option>
                            <option value="4">Товар 4</option>
                            <option value="5">Товар 5</option>
                            <option value="6">Товар 6</option>
                            <option value="7">Товар 7</option>
                        </select>
                        <br>
                        <button class="btn btn-primary" id="addToReceipt">Добавить в чек</button> <br>
                    </div>
                    <div class="col-lg-6">
                        <h2>Товары в чеке</h2>
                        <select size="9" id="printGoods" multiple>
                        </select>
                        <br>
                        <button class="btn btn-primary" id="delFromReceipt">Убрать из чека</button>
                        <button class="btn btn-success" id="printReceipt" >Печать</button>
                        <br>
                        <div id="printResult" class="alert">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    var baseUri = '<?php echo Url::base(true);?>';
    checkGoodList();
    if (getCookie("connected") !== "true") {
        document.getElementById('buttons').hidden = true;
        document.getElementById('printing').hidden = true;
    }

    setShiftStatusResult(getCookie("shift_opened") === "true");


    document.getElementById('printConnect').addEventListener('click', (e) => {
        e.preventDefault();
        getStatus();
    });

    document.getElementById('printOpenShift').addEventListener('click', () => shift("open"));
    document.getElementById('printCloseShift').addEventListener('click', () => shift("close"));
    document.getElementById('addToReceipt').addEventListener('click', () => addGoods());
    document.getElementById('delFromReceipt').addEventListener('click', () => delGoods());
    document.getElementById('printReceipt').addEventListener('click', () => printReceipt('sel'));

    // receiptType: sel or return
    async function printReceipt(receiptType) {
        if (getCookie("shift_opened") !== "true") {
            alert('Смена закрыта');
            return;
        }
        if (document.getElementById('printGoods').children.length === 0) {
            alert('Нет товаров');
            return;
        }

        var goods = {};
        for (let item of document.getElementById('printGoods').children) {
            goods[item.value] = item.textContent;
        }

        var data = new FormData();
        data.append( "json", JSON.stringify({
            'goods': goods,
            'type': receiptType
        }) );

        await fetch(baseUri+'/demo/print', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'goods': goods,
                'type': receiptType
            })
        })
        .then((response) => {
            if (response.status >= 200 && response.status < 300) {
                return response
            } else {
                var error = new Error(response.statusText);
                error.response = response;
                throw error
            }
        })//response.json())
        .then((response) => response.json())
        .then((data) => {
            printerStatus = data;
            console.log(data);
        }).catch((error) => console.log(error));
        setPrintResult(printerStatus);
    }

    function setPrintResult(result) {
        if (result.error) {
            document.getElementById('printResult').classList.remove("alert-success");
            document.getElementById('printResult').classList.add("alert-danger");
            document.getElementById('printResult').innerHTML = result.message;
            return;
        }
        document.getElementById('printResult').classList.remove("alert-danger");
        document.getElementById('printResult').classList.add("alert-success");
        document.getElementById('printResult').innerHTML =
            'Товары: '+JSON.stringify(result.result.goods)+'<br>'
            +'Тип чека: '+(result.result.type === 'sel' ? 'Продажа' : 'Возврат');
    }

    function addGoods() {
        var selected = document.getElementById('allGoods').selectedOptions;
        var added = document.getElementById('printGoods').children;
        for (let item of selected) {
            for (let oneGood of added) {
                if (item.value === oneGood.value) {
                    alert('Товар '+oneGood.value+' уже добавлен');
                    return;
                }
            }
            let option = document.createElement('option');
            option.textContent = item.textContent;
            option.value = item.value;
            document.getElementById('printGoods').appendChild(option);
        }
        checkGoodList();
    }

    function delGoods() {
        var selected = document.getElementById('printGoods').selectedOptions;
        for (let item of selected) {
            document.getElementById('printGoods').removeChild(item);
        }
        checkGoodList();
    }

    function checkGoodList() {
        document.getElementById('printReceipt').disabled = (document.getElementById('printGoods').children.length === 0);
    }

    async function shift(action) {
        var actionUrl = baseUri+'/demo/'+action+'Shift?demo=true';
        await fetch(actionUrl)
            .then((response) => response.json())
            .then((data) => {
                printerStatus = data;
                //console.log(data.result);
            }).catch((error) => console.log(error));

        if (printerStatus.error) {
            alert(printerStatus.message);
        }  else {
            setCookie("shift_opened",printerStatus.result.shift_open,0.5);
            setCookie("connected",printerStatus.result.connected,0.5);
            setShiftStatusResult(printerStatus.result.shift_open);
        }
    }

    async function getStatus() {
        await fetch(baseUri+'/demo/status?demo=true')
            .then((response) => response.json())
            .then((data) => {
                printerStatus = data;
                //console.log(data.result);
            }).catch((error) => console.log(error));

        if (printerStatus.error) {
            alert(printerStatus.message);
            // setCookie("connected","",0.5);
        }  else {
            setCookie("shift_opened",printerStatus.result.shift_open,0.5);
            setCookie("connected",printerStatus.result.connected,0.5);
            setShiftStatusResult(printerStatus.result.shift_open);
            document.getElementById('buttons').hidden = false;
            document.getElementById('printing').hidden = false;
            // setCookie("connected","true",0.5);
            // setCookie("shift_opened",printerStatus.result.shift_open,0.5);
        }
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*1*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function setShiftStatusResult(status) {
        document.getElementById('shiftStatus').innerHTML = (status) ? (
            document.getElementById('printCloseShift').disabled = false,
            document.getElementById('printOpenShift').disabled = true,
            "открыта"
        ) : (
            document.getElementById('printCloseShift').disabled = true,
            document.getElementById('printOpenShift').disabled = false,
            "закрыта"
        );

    }

</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
