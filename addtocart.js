const product = [];
const cart = [];

function fetchCarData() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_cars.php", true);

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
                const [vehicleName, rentCost] = carElement.textContent.split(', ');

                // Find the associated image element
                const imageElement = carElement.nextElementSibling;

                // Construct the car object
                const car = {
                    id: product.length, // Use the current length as id
                    image: imageElement.src,
                    title: vehicleName.split(': ')[1],
                    price: parseFloat(rentCost.split(': ')[1]),
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
    let i = 0;

    document.getElementById('root').innerHTML = categories.map((title) => {
        const item = product.find((productItem) => productItem.title === title);
        const { image, price } = item;
        return (
            `<div class='box'>
                <div class='img-box'>
                    <img class='images' src=${image}></img>
                </div>
                <div class='bottom'>
                    <p>${title}</p>
                    <h2>RS ${price}.00</h2>
                    <button onclick='addtocart(${i++})'>Add to cart</button>
                </div>
            </div>`
        );
    }).join('');
}

function addtocart(a) {
    cart.push({ ...product[a] });
    displaycart();
}

function delElement(a) {
    cart.splice(a, 1);
    displaycart();
}

function displaycart() {
    let j = 0,
        total = 0;
    document.getElementById("count").innerHTML = cart.length;
    if (cart.length == 0) {
        document.getElementById('cartItem').innerHTML = "Your cart is empty";
        document.getElementById("total").innerHTML = "Rs " + 0 + ".00/-";
    } else {
        document.getElementById("cartItem").innerHTML = cart.map((items) => {
            var { image, title, price } = items;
            total = total + price;
            document.getElementById("total").innerHTML = "Rs " + total + ".00/-";
            return (
                `<div class='cart-item'>
                <div class='row-img'>
                    <img class='rowimg' src=${image}>
                </div>
                <p style='font-size:12px;'>${title}</p>
                <h2 style='font-size: 15px;'>Rs ${price}.00</h2>` +
                "<i class='fa-solid fa-trash' onclick='delElement(" + (j++) + ")'></i></div>"
            );
        }).join('');
    }
}

function checkout() {
    if (cart.length > 0) {
        var totalRent = cart.reduce((total, item) => total + item.price, 0);
        var noOfRentedCars = cart.length;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "server.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
            }
        };

        xhr.send("totalRent=" + totalRent + "&noOfRentedCars=" + noOfRentedCars + "&checkout=1");

        window.location.href = 'checkout.php';
    } else {
        alert("Your cart is empty. Add items to the cart before checking out.");
    }
}


// Call the fetchCarData function to retrieve and display car data
fetchCarData();
