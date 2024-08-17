$(document).ready(function(){
    $('#submitcustomer').click(function(event){
        event.preventDefault(); // Prevent the default form submission

        console.log('You have clicked the submit btn');
    
        // Instantiate an xhr object
        const xhr = new XMLHttpRequest();
    
        // Open the object
        xhr.open('POST', '/ptest/ShopHere/routes.php?page=customer_Login', true);
        xhr.setRequestHeader('Content-type', 'application/json');
    
        // What to do when response is ready
        xhr.onload = function () {
            if (this.status === 200) {
                console.log(this.responseText);
    
                    // Redirect to login page
                    window.location.href = '/ptest/ShopHere/routes.php?page=index';
            
            } else {
                console.log("Some error occurred");
            }
        }
    
        // Get form data and serialize it into a JSON object
        let form = document.getElementById('customerlogin');
        let formData = new FormData(form);
        let jsonData = {};
    
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });
    
        // Convert JSON object to string
        let params = JSON.stringify(jsonData);
    
        // Send the request with JSON data
        xhr.send(params);
    
        console.log("We are done!");
    


    })
})

