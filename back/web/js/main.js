let baseUri = window.location.origin;

let controller = window.location.pathname.split( '/' )[1];
let sitePage = window.location.pathname.split( '/' )[2];
console.log(sitePage);
if (controller !== 'demo') {
    controller = 'main';
}

getPrinters();

if(sitePage === 'settings') {
    document.getElementById('savePrinter').addEventListener('click', (e) => {
        e.preventDefault();
        savePrinter();
    });
    document.getElementById('printEdit').addEventListener('click', (e) => {
        e.preventDefault();
        loadSettings(document.getElementById('FormPrinterSelect').value);
    });
    // document.getElementById('printNew').addEventListener('click', (e) => {
    //     e.preventDefault();
    //     newPrinter();
    // });
} else {
    document.getElementById('printCloseShift').disabled = true;
    document.getElementById('printOpenShift').disabled = true;

    checkGoodList();

    document.getElementById('printConnect').addEventListener('click', (e) => {
        e.preventDefault();
        getStatus(document.getElementById('FormPrinterSelect').value);
    });

    document.getElementById('printOpenShift').addEventListener('click', () => shift("open"));
    document.getElementById('printCloseShift').addEventListener('click', () => shift("close"));
    document.getElementById('addToReceipt').addEventListener('click', () => addGoods());
    document.getElementById('delFromReceipt').addEventListener('click', () => delGoods());
    document.getElementById('printReceipt').addEventListener('click', () => printReceipt('sel'));

}
