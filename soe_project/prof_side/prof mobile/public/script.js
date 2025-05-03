
document.getElementById("events-tab").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("events-content").classList.remove("d-none");
    document.getElementById("rooms-content").classList.add("d-none");
    this.classList.add("active");
    document.getElementById("rooms-tab").classList.remove("active");
});

document.getElementById("rooms-tab").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("rooms-content").classList.remove("d-none");
    document.getElementById("events-content").classList.add("d-none");
    this.classList.add("active");
    document.getElementById("events-tab").classList.remove("active");
});

let qrScanner;

document.getElementById("qrScannerModal").addEventListener("shown.bs.modal", function () {
    qrScanner = new Html5Qrcode("qr-reader");
    qrScanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        (decodedText) => {
            alert("QR Code Scanned: " + decodedText);
            qrScanner.stop();
            let modal = bootstrap.Modal.getInstance(document.getElementById("qrScannerModal"));
            modal.hide();
        },
        (errorMessage) => {
            console.log("QR Scanner Error: ", errorMessage);
        }
    ).catch(err => console.log("Camera error: ", err));
});

document.getElementById("qrScannerModal").addEventListener("hidden.bs.modal", function () {
    if (qrScanner) {
        qrScanner.stop().catch(err => console.log("Stop camera error: ", err));
    }
});
