// Function to apply the saved theme from localStorage
function applyTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.classList.add(savedTheme + '-mode');
    document.querySelectorAll('.main-content').forEach(content => {
        content.classList.add(savedTheme + '-mode');
    });
}

// Function to toggle the theme
function toggleTheme() {
    const currentTheme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    // Update body and main-content classes
    document.body.classList.remove(currentTheme + '-mode');
    document.body.classList.add(newTheme + '-mode');
    document.querySelectorAll('.main-content').forEach(content => {
        content.classList.remove(currentTheme + '-mode');
        content.classList.add(newTheme + '-mode');
    });

    // Update localStorage
    localStorage.setItem('theme', newTheme);

    // Update toggle switch state
    const themeSwitch = document.getElementById('theme-switch');
    themeSwitch.checked = newTheme === 'dark';
}

// Apply the saved theme when the page loads
document.addEventListener('DOMContentLoaded', applyTheme);

// Add event listener to the toggle switch
document.getElementById('theme-switch')?.addEventListener('change', toggleTheme);