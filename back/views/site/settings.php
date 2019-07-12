<?php

/* @var $this yii\web\View */

/**
 * @var $provider \yii\data\ActiveDataProvider
 */

use yii\web\View;

$this->title = 'ATOL PrintServer settings';
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

                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <button id="printEdit" class="btn btn-info col-md" type="submit">Редактировать</button>
<!--                        <button id="printNew" class="btn btn-danger col-md" type="submit">Новый</button>-->
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <h3>Настройки принтера</h3>
            <div class="col-md-12 col-12">
                <form id="settingsForm">
                    <input type="hidden" name="printer_id" value="">
                    <div class="form-group">
                        <label for="nameLabel">Имя</label>
                        <input type="text" name="printer_name" class="form-control" id="nameLabel" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="nameDescr">Описание</label>
                        <input type="text" name="description" class="form-control" id="nameDescr">
                    </div>
                    <div class="form-group">
                        <label for="nameAddr">ИП адрес</label>
                        <input type="text" name="connect_string" class="form-control" id="nameAddr">
                    </div>
                    <button id="savePrinter" name="saveBtn" type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>