// Add event listener for the 'Add to Cart' buttons


// $(document).ready(function(){
// console.log('doc loadzsdvsdfved');
//     $("#remove-item").click(function(){
//         console.log('remove btn clicked');
//     })
// });
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Preventing the default form submission

        console.log('Add to Cart button clicked');

        let productsno = event.target.getAttribute('data-product-sno');
        let productprice = event.target.getAttribute('data-product-price');

        // Creating an XHR object
        const xhr = new XMLHttpRequest();

        // Open the POST request
        xhr.open('POST', '/ptest/ShopHere/routes.php?page=cartajax', true);
        xhr.setRequestHeader('Content-type', 'application/json');

        // Defining the response handling
        xhr.onload = function() {
            console.log('Request returned successfully');
            if (this.status === 200) {
                console.log('Product added to cart successfully!');
                alert('Product added to cart successfully!');
                // Optionally update cart content dynamically here
                // If the cart content is updated dynamically, make sure to re-attach the event listener to the new remove-item buttons
                // attachRemoveItemListeners(); // Re-attach listeners to any new remove-item buttons
            } else {
                alert('Something went wrong.');
            }
        };

        let params = JSON.stringify({
            productsno: productsno,
            quantity: 1,
            productprice: productprice
        });

        xhr.send(params);
    });
});

// Function to attach event listeners to remove-item buttons
// function attachRemoveItemListeners() {
//     document.querySelectorAll('#remove-item').forEach(button => {
//         button.addEventListener('click', function(event) {
//             console.log('Remove button clicked');
//             let index = event.target.getAttribute('data-index');

            // Handle the removal process here
            // For example, send an AJAX request to remove the item from the cart on the server
            // alert('Item removed from cart: ' + index);

            // Optionally remove the item from the DOM
            // event.target.closest('.productDetailsdiv').remove();
//         });
//     });
// }

// Initially attach event listeners to any existing remove-item buttons
// attachRemoveItemListeners();

// Show the cart modal when the cart icon is clicked
document.addEventListener("navbarLoaded", () => {
    const cartIcon = document.getElementById('cartIcon');
    cartIcon.addEventListener("click", () => {
        console.log('Cart icon clicked');
        const cartModal = document.getElementById('cartModal');
        const bsOffcanvas = new bootstrap.Offcanvas(cartModal);
        
        // Show the offcanvas
        bsOffcanvas.show();

        // Add event listener for when the offcanvas is shown
        cartModal.addEventListener('shown.bs.offcanvas', () => {
            console.log('Offcanvas is shown');

            // Select all remove buttons in the cart
            const removeButtons = document.getElementById('remove-item');
            console.log(removeButtons);

            // $( ".remove-item" ).click(function() {
            //     console.log("remove btn clicked");

            // });
            // removeButtons.forEach(button => {
                removeButtons.addEventListener('click', function(event) {
                    console.log('Remove button clicked');
                    let product_sno = event.target.getAttribute('data-index');

                    const xhr = new XMLHttpRequest();

                    // Open the POST request
                    xhr.open('POST', '/ptest/ShopHere/routes.php?page=removeCartItem', true);
                    xhr.setRequestHeader('Content-type', 'application/json');
            
                    // Defining the response handling
                    xhr.onload = function() {
                        console.log('Request returned successfully');
                        if (this.status === 200) {
                            console.log('Product deleted from cart successfully!');
                            alert('Item removed from cart');
                            // Optionally update cart content dynamically here
                            // If the cart content is updated dynamically, make sure to re-attach the event listener to the new remove-item buttons
                            // attachRemoveItemListeners(); // Re-attach listeners to any new remove-item buttons
                        } else {
                            alert('Something went wrong.');
                        }
                    };
            
                    let params = JSON.stringify({
                        product_sno: product_sno,
                    });
            
                    xhr.send(params);

                    // Handle the removal process here
                    



                    // Optionally remove the item from the DOM
                    // event.target.closest('.productDetailsdiv').remove();
                });
                console.log('after remove btn');
            // });
        });
    });
});

