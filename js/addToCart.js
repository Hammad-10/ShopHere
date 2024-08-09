document.addEventListener("navbarLoaded", () => { // Listen for navbarLoaded event
    const addtocartButtons = document.querySelectorAll('.add-to-cart');
    const cartIcon = document.getElementById('cartIcon');
    const cartItemsList = document.getElementById('cartItemsList');
    const clearCartButton = document.getElementById('clearCartButton');
    
    let cartItems = [];
  
    addtocartButtons.forEach(button => {
      button.addEventListener("click", (e) => {
        e.preventDefault();
  
        const productDiv = button.closest('.product-item');
        
        if (productDiv) {
          const imageSrc = productDiv.querySelector('.productImage').src;
          const title = productDiv.querySelector('.card-title').innerText;
          const price = productDiv.querySelector('.card-text').innerText.replace('$', '').trim();
  
          const item = { imageSrc, title, price };
          cartItems.push(item);
          updateCart();
        } else {
          console.error("Product item container not found!");
        }
      });
    });
  
    cartIcon.addEventListener("click", () => {
      // Trigger the offcanvas manually if not using data attributes
      const cartModal = document.getElementById('cartModal');
      const bsOffcanvas = new bootstrap.Offcanvas(cartModal);
      bsOffcanvas.show();
    });
  
    clearCartButton?.addEventListener("click", () => {
      cartItems = [];
      updateCart();
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
  
      const removeButtons = document.querySelectorAll('.remove-item');
      removeButtons.forEach(button => {
        button.addEventListener("click", (e) => {
          const index = e.target.getAttribute('data-index');
          cartItems.splice(index, 1);
          updateCart();
        });
      });
    }
});
