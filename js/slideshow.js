const slider = document.querySelector('.slider');
const images = slider.children;
let currentImage = 0;

images[currentImage].classList.add('active');

slider.addEventListener('click', () => {
images[currentImage].classList.remove('active');
currentImage = (currentImage + 1) % images.length;
images[currentImage].classList.add('active');
});
