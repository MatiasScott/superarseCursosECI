function openTab(evt, tabName) {
    let i, tabPane, tabBtn;
    tabPane = document.getElementsByClassName("tab-pane");
    for (i = 0; i < tabPane.length; i++) {
        tabPane[i].classList.remove("active");
    }

    tabBtn = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tabBtn.length; i++) {
        tabBtn[i].classList.remove("active");
    }

    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}

// Lógica del selector de pago (tu código original)
const selector = document.getElementById('selector-metodo');
const transferenciaDiv = document.getElementById('info-transferencia');
selector.addEventListener('change', function () {
    if (this.value === 'transferencia') {
        transferenciaDiv.style.display = 'block';
    } else {
        transferenciaDiv.style.display = 'none';
    }
});