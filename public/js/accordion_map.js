

// ACCORDION JS 
var acc = document.querySelectorAll('.place-title');
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener('click', function() {
    this.classList.toggle('active');
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + 'px';
    }
  });
}


// GALLERY

// Function to show the enlarged image when an image in the gallery is clicked
// function showEnlargedImage(event) {
//   const src = event.target.src;
//   const alt = event.target.alt;
//   document.getElementById('enlarged-image').src = src;
//   document.getElementById('enlarged-image').alt = alt;
//   document.querySelector('.enlarged-image').style.display = 'flex';
// }


// Function to close the enlarged image when the close button is clicked
function closeEnlargedImage() {
  const enlargedImageContainer = document.querySelector('.enlarged-image');
  enlargedImageContainer.style.display = 'none';
}

// Add event listeners to the images in the gallery and the close button
const images = document.querySelectorAll('.gallery img');
images.forEach(image => {
  image.addEventListener('click', showEnlargedImage);
});

const closeButton = document.getElementById('close-button');
closeButton.addEventListener('click', closeEnlargedImage);