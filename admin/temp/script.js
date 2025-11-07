// Select elements
const aboveImage = document.getElementById('aboveImage');
const belowImage = document.getElementById('belowImage');
const increaseSizeButton = document.getElementById('increaseSize');
const decreaseSizeButton = document.getElementById('decreaseSize');

// Variables for drag functionality
let isDragging = false;
let offsetX = 0;
let offsetY = 0;

// Get boundaries of the below image
const containerBounds = belowImage.getBoundingClientRect();

// Function to handle resizing
function resizeImage(increase) {
  const currentSize = parseInt(window.getComputedStyle(aboveImage).width);
  const newSize = increase ? currentSize + 20 : Math.max(currentSize - 20, 50); // Minimum size: 50px
  aboveImage.style.width = `${newSize}px`;
  aboveImage.style.height = `${newSize}px`; // Maintain aspect ratio by setting height equal to width
  // Save the updated size to local storage
  saveState();
}

// Add event listeners for resizing buttons
increaseSizeButton.addEventListener('click', () => resizeImage(true));
decreaseSizeButton.addEventListener('click', () => resizeImage(false));

// Function to handle drag start
aboveImage.addEventListener('mousedown', (e) => {
  isDragging = true;
  offsetX = e.clientX - aboveImage.offsetLeft;
  offsetY = e.clientY - aboveImage.offsetTop;
});

// Function to handle drag movement
document.addEventListener('mousemove', (e) => {
  if (!isDragging) return;
  let newLeft = e.clientX - offsetX;
  let newTop = e.clientY - offsetY;

  // Enforce boundaries
  const aboveImageBounds = aboveImage.getBoundingClientRect();
  const maxLeft = containerBounds.width - aboveImageBounds.width;
  const maxTop = containerBounds.height - aboveImageBounds.height;

  newLeft = Math.max(0, Math.min(newLeft, maxLeft));
  newTop = Math.max(0, Math.min(newTop, maxTop));

  aboveImage.style.left = `${newLeft}px`;
  aboveImage.style.top = `${newTop}px`;

  // Save the updated position to local storage
  saveState();
});

// Function to handle drag end
document.addEventListener('mouseup', () => {
  isDragging = false;
});

// Function to save the state of the image to local storage
function saveState() {
  const state = {
    width: aboveImage.style.width,
    height: aboveImage.style.height,
    left: aboveImage.style.left,
    top: aboveImage.style.top,
  };
  localStorage.setItem('imageState', JSON.stringify(state));
}

// Function to load the state of the image from local storage
function loadState() {
  const savedState = localStorage.getItem('imageState');
  if (savedState) {
    const state = JSON.parse(savedState);
    aboveImage.style.width = state.width || '100px'; // Default width if not saved
    aboveImage.style.height = state.height || '100px'; // Default height if not saved
    aboveImage.style.left = state.left || '50px'; // Default left position if not saved
    aboveImage.style.top = state.top || '50px'; // Default top position if not saved
  }
}

// Load the saved state when the page loads
window.addEventListener('DOMContentLoaded', loadState);