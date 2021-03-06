// function clearList(select) {
//
//
// }

function setPrinterList(printers) {
    if (printers.length === 0) {
        return;
    }
    // clearList(document.getElementById('FormPrinterSelect'));
    while (document.getElementById('FormPrinterSelect').length > 0) {
        document.getElementById('FormPrinterSelect').remove(document.getElementById('FormPrinterSelect').length - 1)
    }
    printers.forEach(el => {
        let option = document.createElement('option');
        option.textContent = el.printer_name;
        option.value = el.printer_id;
        document.getElementById('FormPrinterSelect').appendChild(option);
    });
}

function setShiftAction(action) {
    document.getElementById('shiftStatus').innerHTML = (action === 'open') ? "открываем..." : "закрываем...";
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

function checkGoodList() {
    document.getElementById('printReceipt').disabled = (document.getElementById('printGoods').children.length === 0);
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

function setPrinterSettings(printers) {
    if (printers.length === 0) {
        return;
    }
    var elements = document.getElementById("settingsForm").elements;
    elements.namedItem('printer_id').value = printers.printer_id;
    elements.namedItem('printer_name').value = printers.printer_name;
    elements.namedItem('description').value = printers.description;
    elements.namedItem('connect_string').value = printers.connect_string;
}