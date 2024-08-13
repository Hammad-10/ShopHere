document.addEventListener("navbarLoaded", () => {
    const addtocartButtons = document.querySelectorAll('.add-to-cart');
    const cartIcon = document.getElementById('cartIcon');
    const cartItemsList = document.getElementById('cartItemsList');
    const clearCartButton = document.getElementById('clearCartButton');
    const checkoutButton = document.querySelector('.checkoutBtn');
    
    let cartItems = [];
  
    // Adding items to the cart
    addtocartButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
  
            // Get the product details
            const imageSrc = document.querySelector('.productImage').src; // Image is outside the .product-item
            const title = document.querySelector('.product-item .card-title').innerText;
            const price = document.querySelector('.product-item .card-text').innerText.replace('$', '').trim();
  
            const item = { imageSrc, title, price };
            cartItems.push(item);
            updateCart();
        });
    });
  
    cartIcon.addEventListener("click", () => {
        const cartModal = document.getElementById('cartModal');
        const bsOffcanvas = new bootstrap.Offcanvas(cartModal);
        bsOffcanvas.show();
    });
  
    clearCartButton?.addEventListener("click", () => {
        cartItems = [];
        updateCart();
    });
  
    checkoutButton.addEventListener("click", (e) => {
        e.preventDefault();
  
        if (cartItems.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/ptest/ShopHere/models/addToCart.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
  
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Order processed successfully.");
                    window.location.href = "/ptest/ShopHere/routes.php?page=checkout";
                }
            };
  
            const orderData = {
                cartItems: cartItems
            };
            xhr.send(JSON.stringify(orderData));
        }
    });
  
  
    function updateCart() {
        cartItemsList.innerHTML = '';
        cartItems.forEach(item => {
            const cartItemHTML = `
                <div class="cart-item">
                    <img src="${item.imageSrc}" alt="${item.title}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h5>${item.title}</h5>
                        <p>$${item.price}</p>
                    </div>
                </div>
            `;
            cartItemsList.insertAdjacentHTML('beforeend', cartItemHTML);
        });

        updateCartCounter();
    }

    function updateCartCounter() {
        const cartCounter = document.getElementById('cartCounter');
        if (cartCounter) {
            cartCounter.innerText = cartItems.length;
        }
    }
});