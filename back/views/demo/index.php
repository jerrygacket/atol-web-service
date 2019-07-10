<?php

/* @var $this yii\web\View */

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