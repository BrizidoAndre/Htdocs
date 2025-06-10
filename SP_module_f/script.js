let btnAction = document.querySelector('.container-button-action')
let btnBackground = document.querySelector('.hover-effect-action')
let video = document.getElementById('video')
let btnSpeak = document.querySelector('.button-speak')
let message = new SpeechSynthesisUtterance('Mairie de Lyon, 69205 Lyon cedex 01')

const observer = new IntersectionObserver(entries =>{
     if(entries[0].isIntersecting){
          video.play();
     }
     else{
          video.pause();
     }
},{
     threshold: .5
})

btnAction.addEventListener('mousemove',(ev)=>{
     let mouseX = ev.x;
     let mouseY = ev.y;
     let position = btnAction.getBoundingClientRect();
     let positionX = mouseX - position.x;
     let positionY = mouseY - position.y;
     btnBackground.style.display = 'block';
     btnBackground.style.top = positionY + 'px';
     btnBackground.style.left = positionX + 'px';
})

btnAction.addEventListener('mouseleave',()=>{
     btnBackground.style.display = 'none';
})

observer.observe(video);

btnSpeak.addEventListener('click',()=>{
     window.speechSynthesis.cancel();
     window.speechSynthesis.speak(message);
})

// if the user is offline
if(!navigator.onLine){
     let header = document.querySelector('header');
     let footer = document.querySelector('footer');
     let essential = document.querySelector('#essential');
     const sections = document.querySelectorAll('section')
     const halfs = document.querySelectorAll('.container-half')
     sections.forEach(section=>{
          section.style.display = 'none';
     })
     halfs[1].style.display = 'none'
     video.style.display = `none`;
     footer.style.display = 'none';
     essential.style.display = 'flex';
     header.style.display = 'flex';
}