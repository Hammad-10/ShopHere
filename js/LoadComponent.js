// Function to load HTML content
function loadHTML(url, elementId) {
    fetch(url)
      .then(response => response.text())
      .then(data => {
        document.getElementById(elementId).innerHTML = data;
      })
      .catch(error => console.error('Error loading HTML:', error));
  }
  
  // Load the navbar and footer
  document.addEventListener('DOMContentLoaded', () => {
    loadHTML('navbar.html', 'navbar');
    loadHTML('footer.html', 'footer');
  });
  