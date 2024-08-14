document.addEventListener("navbarLoaded", () => {
    console.log('DOM fully loaded and parsed: in cart counter file');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartCounter = document.getElementById('cart-counter');
    let counter = 0;

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
          
            event.preventDefault();
            counter++;
            if (cartCounter) {
          
                cartCounter.textContent = counter;
                // Temporarily change color to check if it updates
                cartCounter.style.color = 'white';
                console.log('Cart counter updated: ', counter);
            }
        });
    });
});