let currentIndex = 0;
let slideshowInterval = null;

const imageList = document.getElementById('imageList');
const displayedImage = document.getElementById('displayedImage');
const backBtn = document.getElementById('backBtn');
const nextBtn = document.getElementById('nextBtn');
const slideshowBtn = document.getElementById('slideshowBtn');
const imageInfo = document.getElementById('imageInfo');

function updateImage() {
    const selectedImage = imageList.options[currentIndex].value;
    displayedImage.src = selectedImage;
    imageInfo.textContent = `${imageList.options[currentIndex].text} (${currentIndex + 1}/${imageList.options.length})`;
}

function next() {
    currentIndex = (currentIndex + 1) % imageList.options.length;
    updateImage();
}

function back() {
    currentIndex = (currentIndex - 1 + imageList.options.length) % imageList.options.length;
    updateImage();
}

function toggleSlideshow() {
    if (slideshowInterval === null) {
        // Start slideshow
        slideshowBtn.textContent = 'Stop slideshow';
        backBtn.disabled = true;
        nextBtn.disabled = true;
        slideshowInterval = setInterval(next, 1000);
    } else {
        // Stop slideshow
        slideshowBtn.textContent = 'Start slideshow';
        backBtn.disabled = false;
        nextBtn.disabled = false;
        clearInterval(slideshowInterval);
        slideshowInterval = null;
    }
}

// Event listeners
backBtn.addEventListener('click', back);
nextBtn.addEventListener('click', next);
slideshowBtn.addEventListener('click', toggleSlideshow);
imageList.addEventListener('change', (e) => {
    currentIndex = e.target.selectedIndex;
    updateImage();
});
