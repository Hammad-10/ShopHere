// checkout.js

document.querySelector('.checkoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    // Gather cart data
    const cartData = getCartData(); // A function to retrieve cart data
    if (cartData) {
      // Send the data to the server
      fetch('/ptest/ShopHere/controller/processOrder.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(cartData),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Redirect or show success message
          window.location.href = '/ptest/ShopHere/views/orderSuccess.html';
        } else {
          // Handle errors
          console.error(data.message);
        }
      })
      .catch(error => console.error('Error:', error));
    }
  });
  
  function getCartData() {
    // Extract cart information from the DOM or local storage
    // Return as an object or array

    function getCartData() {
        let cartItems = [];
        document.querySelectorAll('#cartItemsList .cart-item').forEach(item => {
          const productId = item.getAttribute('data-product-id');
          const quantity = item.querySelector('.quantity').textContent;
          const price = item.querySelector('.price').textContent;
      
          cartItems.push({
            product_id: productId,
            quantity: parseInt(quantity),
            price: parseFloat(price)
          });
        });
        
        return {
          items: cartItems,
          total: calculateTotal(cartItems)
        };
      }
      
      function calculateTotal(cartItems) {
        return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
      }
      
  }
  