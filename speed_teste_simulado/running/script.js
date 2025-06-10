const image = document.getElementById('person')
let imagePosition = 20;

function walking() {
    setTimeout(() => {
        if (imagePosition > 1000) {
            imagePosition = 0;
        } else {
            imagePosition += 207
        }
        image.style.backgroundPositionX = -imagePosition + 'px';
        walking()
    }, 100)
}

walking()