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

            const productDiv = button.closest('.product-item');
            if (productDiv) {
                const imageSrc = productDiv.querySelector('.productImage').src;
                const title = productDiv.querySelector('.card-title').innerText;
                const price = productDiv.querySelector('.card-text').innerText.replace('$', '').trim();

                // Check if the item already exists in the cart
                const itemExists = cartItems.some(item => item.title === title);

                if (!itemExists) {
                    // If the item is not already in the cart, add it
                    const item = { imageSrc, title, price };
                    cartItems.push(item);
                    updateCart();
                } else {
                    showAlert("Item already in cart");
                }
            } else {
                console.error("Product item container not found!");
            }
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
        cartItemsList.innerHTML = "";

        cartItems.forEach((item, index) => {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.className = 'maindiv mb-3';

            cartItemDiv.innerHTML = `
                <div class="imageDiv">
                    <img alt="${item.title}" class="productImage" src="${item.imageSrc}">
                </div>
                <div class="productDetailsdiv">
                    <h5>${item.title}</h5>
                    <p><strong>Price:</strong> $${item.price}</p>
                    <select title="quantity" id="quantity-${index}">
                        <option value="1">1</option>
                    </select>
                    <button class="btn btn-danger btn-sm ms-2 remove-item" data-index="${index}">Remove</button>
                </div>
            `;

            cartItemsList.appendChild(cartItemDiv);
        });

        // Attach event listeners for remove buttons after the cart is updated
        attachRemoveItemListeners();
    }

    function attachRemoveItemListeners() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener("click", (e) => {
                console.log('remove btn clicked');
                const index = e.target.getAttribute('data-index');
                cartItems.splice(index, 1);
                updateCart(); // Re-render the cart with updated indices
            });
        });
    }

    function showAlert(message) {
        // Create the alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning alert-dismissible fade show';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Append the alert to the alertmsg div
        const alertContainer = document.querySelector('.alertmsg');
        if (alertContainer) {
            alertContainer.innerHTML = ""; // Clear any existing alerts
            alertContainer.appendChild(alertDiv);
            
            // Automatically remove the alert after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                alertDiv.classList.add('fade');
                setTimeout(() => {
                    alertDiv.remove();
                }, 150);
            }, 5000);
        } else {
            console.error("Alert container not found!");
        }
    }
});
