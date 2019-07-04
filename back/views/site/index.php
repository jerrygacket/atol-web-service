<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

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