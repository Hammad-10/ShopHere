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

    cartIcon.addEventListener("click", (e) => {
        e.preventDefault();
    
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            // Destroy existing instance if any to avoid conflicts
            const existingInstance = bootstrap.Offcanvas.getInstance(cartModal);
            if (existingInstance) {
                existingInstance.dispose();
            }
    
            // Initialize a new Offcanvas instance
            const bsOffcanvas = new bootstrap.Offcanvas(cartModal, {
                backdrop: true, // Set the backdrop to true explicitly
                keyboard: true, // Allow closing with escape key
            });
    
            bsOffcanvas.show();
        } else {
            console.error("Cart modal not found!");
        }
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
                        <!-- Add more options as needed -->
                    </select>
                    <button class="btn btn-danger btn-sm ms-2 remove-item" data-index="${index}">Remove</button>
                </div>
            `;
    
            cartItemsList.appendChild(cartItemDiv);
        });
    
        // Attach event listener to the parent container using event delegation
        cartItemsList.addEventListener('click', function (e) {
            // Check if the clicked element is the remove button
            if (e.target && e.target.classList.contains('remove-item')) {
                const index = e.target.getAttribute('data-index');
                cartItems.splice(index, 1);
                updateCart(); // Re-render the cart with updated indices
            }
    
            // Handle quantity change if the quantity dropdown is clicked
            if (e.target && e.target.tagName === 'SELECT' && e.target.title === 'quantity') {
                const index = e.target.id.split('-')[1];
                const selectedQuantity = e.target.value;
                console.log(`Quantity for item ${index} changed to ${selectedQuantity}`);
                // Implement any logic you need to update the item quantity in cartItems
            }
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
