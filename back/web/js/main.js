let baseUri = window.location.origin;

let controller = window.location.pathname.split( '/' )[1];
if (controller === '') {
    controller = 'main';
}


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

