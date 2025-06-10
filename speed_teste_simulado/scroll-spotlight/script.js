const spot = document.querySelector('.spot')
let spotSize = 10;
window.addEventListener('mousemove', (ev) => {
    spot.style.left = ev.x + 'px';
    spot.style.top = ev.y + 'px';
})


window.addEventListener('wheel', (ev) => {
    if (ev.deltaY < 0) {
        spotSize += 10;
    } else if (spotSize > 10) {
        spotSize -= 10;
    }
    spot.style.width = spotSize + 'px';
})