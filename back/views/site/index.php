<?php

/* @var $this yii\web\View */

$this->title = 'ATOL PrintServer';
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
                        Загружаем список принтеров
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" id="FormPrinterSelect">
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
                    <div class="col-lg-4">
                        <h2>Чек прихода</h2>
                        <input type="text" placeholder="Номер заказа" id="order_income">
                        <button class="btn btn-primary" id="check_income"> Проверить</button> <br>
                        <div id="checkres_income" style="margin-top:20px;"></div>
                        <button class="btn btn-success" id="print_income" style="visibility:hidden"> Печать чека</button>
                        <div id="printres_income" style="margin-top:20px;"></div>
                    </div>
                    <div class="col-lg-4">
                        <h2>Чек возврата</h2>
                        <input type="text" placeholder="Номер заказа" id="order_return">
                        <button class="btn btn-primary" id="check_return"> Проверить</button>
                        <div id="checkres_return" style="margin-top:20px;"></div>
                        <button class="btn btn-success" id="print_return" style="visibility:hidden"> Печать чека</button>
                        <div id="printres_return" style="margin-top:20px;"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    if (getCookie("connected") !== "true") {
        document.getElementById('buttons').hidden = true;
        document.getElementById('printing').hidden = true;
    }

    // document.getElementById('shiftStatus').innerHTML = (getCookie("shift_opened") === "true") ? "открыта" : "закрыта";
    document.getElementById('shiftStatus').innerHTML = (getCookie("shift_opened") === "true") ? (
        document.getElementById('printCloseShift').disabled = false,
        document.getElementById('printOpenShift').disabled = true,
        "открыта"
    ) : (
        document.getElementById('printCloseShift').disabled = true,
        document.getElementById('printOpenShift').disabled = false,
        "закрыта"
    );

    let printersList = false;
    [...document.getElementsByClassName('valid-name')].forEach(el => {
        el.addEventListener('change', async () => {
            if (!printersList) {
                let printers;
                printers = await getPrinters();
                printers.forEach(el => {
                    let option = document.createElement('option');
                    option.textContent = el.printer_name;
                    option.value = el.printer_id;
                    document.getElementById('FormPrinterSelect').appendChild(option);
                });
                printersList = true;
            }
        });
    });

    document.getElementById('printConnect').addEventListener('click', (e) => {
        e.preventDefault();
        // printConnect();
        getStatus();
    });

    document.getElementById('printOpenShift').addEventListener('click', () => getGoods());
    document.getElementById('printCloseShift').addEventListener('click', () => getGoods());
    // document.getElementById('goodsButton').addEventListener('click', () => getGoods());
    // document.getElementById('printStatus').addEventListener('click', () => getStatus());

    async function getStatus() {
        let printerId = document.getElementById('FormPrinterSelect').value;
        await fetch('http://atol.fdp/main/status?info[printer_id]='+printerId)
            .then((response) => response.json())
            .then((data) => {
                printerStatus = data;
                //console.log(data.result);
            }).catch((error) => console.log(error));

        if (printerStatus.error) {
            alert(printerStatus.message);
            setCookie("connected","",0.5);
        }  else {
            document.getElementById('shiftStatus').innerHTML = printerStatus.result.shift_open ? "открыта" : "закрыта";
            document.getElementById('buttons').hidden = false;
            document.getElementById('printing').hidden = false;
            setCookie("connected","true",0.5);
            setCookie("shift_opened",printerStatus.result.shift_open,0.5);
        }


        // let goodsAll = document.getElementById('goodsAll');
        // goodsAll.textContent = "";
        //
        // let goodsList = document.createElement('ul');
        // goodsList.className = "goodsList";
        // let goodsSum = document.createElement('div');
        // let sum = 0;
        // goodsAll.appendChild(goodsList);
        // goodsAll.appendChild(goodsSum);
        //
        // goods.forEach((el, i) => {
        //     let elemLi = document.createElement('li');
        //     elemLi.textContent = `${el.name} -- ${el.price}`;
        //     goodsList.appendChild(elemLi);
        //
        //     sum += +(el.price);
        //     goodsSum.textContent = `Итого: ${ sum } руб.`;
        // });


    }

    async function getGoods() {
        let goods = [];
        await fetch('http://atol.fdp/main/getGoods')
            .then((response) => response.json())
            .then((data) => {
                goods = data.result;
            }).catch((error) => console.log(error));

        let goodsAll = document.getElementById('goodsAll');
        goodsAll.textContent = "";

        let goodsList = document.createElement('ul');
        goodsList.className = "goodsList";
        let goodsSum = document.createElement('div');
        let sum = 0;
        goodsAll.appendChild(goodsList);
        goodsAll.appendChild(goodsSum);

        goods.forEach((el, i) => {
            let elemLi = document.createElement('li');
            elemLi.textContent = `${el.name} -- ${el.price}`;
            goodsList.appendChild(elemLi);

            sum += +(el.price);
            goodsSum.textContent = `Итого: ${ sum } руб.`;
        });
    }

    async function printConnect() {
        let isConnect = false;
        let printerId = document.getElementById('FormPrinterSelect').value;
        await fetch('http://atol.fdp/main/status?info[printer_id]='+printerId)
            .then(response => response.json())
            .then((data) => {
                if (!data.error) isConnect = true;
                console.log('status', data);
            }).catch((error) => console.log(error));
        if (isConnect) {
            document.getElementById('printConnect').classList.add('success');
            document.getElementById('printConnect').textContent="Подключено";
            document.getElementById('goods').style.display = 'flex';
            document.getElementById('buttons').hidden = false;
        } else {
            document.getElementById('printConnect').classList.add('fail');
            document.getElementById('printConnect').textContent="Ошибка";
        }
    }

    async function getPrinters() {
        let printers = [];
        await fetch('http://atol.fdp/main/getPrinters?info[user_id]=some_id', {
            method: 'GET'
        })
            .then(response => response.json())
            .then((data) => {
                data.result.forEach((el, i) => {
                    printers.push(el);
                })
            });
        return printers;
    }

    document.addEventListener("DOMContentLoaded", async () => {
        document.getElementById('FormPrinterSelect').disabled = false;
        document.getElementById('printConnect').disabled = false;
        if (!printersList) {
            let printers;
            printers = await getPrinters();
            printers.forEach(el => {
                let option = document.createElement('option');
                option.textContent = el.printer_name;
                option.value = el.printer_id;
                document.getElementById('FormPrinterSelect').appendChild(option);
            });
            printersList = true;
        }
        document.getElementById('connectInfo').innerHTML = "Принтеры: ";
    });

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

</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>