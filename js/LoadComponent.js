// Function to load HTML content
function loadHTML(url, elementId) {
  return fetch(url)
    .then(response => response.text())
    .then(data => {
      document.getElementById(elementId).innerHTML = data;
    })
    .catch(error => console.error('Error loading HTML:', error));
}

// Load the navbar and footer
document.addEventListener('DOMContentLoaded', async () => {
  await loadHTML('/ptest/ShopHere/views/navbar.html', 'navbar');
  document.dispatchEvent(new Event('navbarLoaded')); // Dispatch custom event
  loadHTML('/ptest/ShopHere/views/footer.html', 'footer');
});
