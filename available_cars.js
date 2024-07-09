const product = [];
const cart = [];

function fetchCarData() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "admin_get_cars.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Assuming the server echoes HTML with the car data
            // Extract the data from the HTML response
            const parser = new DOMParser();
            const doc = parser.parseFromString(xhr.responseText, 'text/html');

            // Select all p elements inside the document (assuming each p element contains car data)
            const carElements = doc.querySelectorAll('p');

            // Loop through the p elements and extract data
            carElements.forEach((carElement) => {
                // Parse the text content of the p element to extract data
                const [vehicleName, rentCost, make, fuelType, color, capacity] = carElement.textContent.split(', ');

                // Find the associated image element
                const imageElement = carElement.nextElementSibling;

                // Construct the car object
                const car = {
                    id: product.length, // Use the current length as id
                    image: imageElement.src,
                    title: vehicleName.split(': ')[1],
                    price: parseFloat(rentCost.split(': ')[1]),
                    make: make,
                    fuelType: fuelType,
                    color: color,
                    capacity: capacity,
                };

                // Add the car to the product array
                product.push(car);
            });

            // After fetching data, call the function to display products
            displayProducts();
        }
    };

    xhr.send();
}

function displayProducts() {
    const categories = [...new Set(product.map((item) => item.title))];
    
    document.getElementById('root').innerHTML = categories.map((title) => {
        const item = product.find((productItem) => productItem.title === title);
        const { image, price, make, fuelType, color, capacity } = item;
        return (
            `<div class='box'>
                <div class='img-box'>
                    <img class='images' src=${image}></img>
                </div>
                <div class='bottom'>
                    <h2>${title}</h2>
                    <p>RS ${price}.00</p>
                    <p>${make}</p>
                    <p>${fuelType}</p>
                    <p>${color}</p>
                    <p>${capacity}</p>
                </div>
            </div>`
        );
    }).join('');
}



function delElement(a) {
    cart.splice(a, 1);
    displaycart(); 
}

// Call the fetchCarData function to retrieve and display car data
fetchCarData();
