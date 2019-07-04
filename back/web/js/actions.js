async function shift(action) {
    var actionUrl = '/'+controller+'/'+action+'Shift';
    await sendRequest(actionUrl)
        .then((response) =>  {
            printerStatus = response;
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
    await sendRequest('/'+controller+'/status')
        .then((response) => {
            printerStatus = response;
        }).catch((error) => console.log(error));

    if (printerStatus.error) {
        alert(printerStatus.message);
        // setCookie("connected","",0.5);
    }  else {
        console.log(printerStatus);
        setCookie("shift_opened",printerStatus.result.shift_open,0.5);
        setCookie("connected",printerStatus.result.connected,0.5);
        setShiftStatusResult(printerStatus.result.shift_open);
        document.getElementById('buttons').hidden = printerStatus.result.connected === 'false';
        document.getElementById('printing').hidden = printerStatus.result.connected === 'false';
    }
}

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

    var data = {
        'goods': goods,
        'type': receiptType
    };

    await sendRequest('/'+controller+'/print', data, 'POST')
        .then((response) => {
            printerStatus = response;
        }).catch((error) => console.log(error));

    setPrintResult(printerStatus);
}