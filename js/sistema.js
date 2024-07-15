// Funcionamento Menu Lateral
const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    modeText = body.querySelector(".mode-text"),
    customText = body.querySelector(".custom-text");

// Abre-Fecha Menu Lateral
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    customText.classList.toggle("hidden");
});

function changeBackgroundColor(button, isHover) {
    const icon = button.querySelector('i');

    if (isHover) {
        button.style.backgroundColor = '#9a4dff';
        icon.style.color = '#FFF';
    } else {
        button.style.backgroundColor = '#FFF';
        icon.style.color = '#707070';
    }
}