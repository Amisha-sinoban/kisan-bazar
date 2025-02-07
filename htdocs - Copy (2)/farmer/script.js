function addItem() {
    let itemName = document.getElementById("itemName").value;
    let itemQuantity = document.getElementById("itemQuantity").value;
    let itemPrice = document.getElementById("itemPrice").value;
    let itemCategory = document.getElementById("itemCategory").value;

    fetch("add_item.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `item_name=${itemName}&quantity=${itemQuantity}&price=${itemPrice}&category=${itemCategory}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            location.reload(); // Refresh to show new item
        } else {
            alert(data.message);
        }
    });
}
function initializeNavbar() {
    const navbar = document.createElement("nav");
    document.body.prepend(navbar);
}

initializeNavbar();
function toggleNav() {
    var sideNav = document.getElementById("sideNav");
    if (sideNav.style.width === "250px") {
        sideNav.style.width = "0";
    } else {
        sideNav.style.width = "250px";
    }
}

const categories = [
    { name: "Food Grains/Cereals", img: "grains-icon.png", id: "grainsList" },
    { name: "Pulses/Legumes", img: "pulses-icon.png", id: "pulsesList" },
    { name: "Oilseeds", img: "oilseeds-icon.png", id: "oilseedsList" },
    { name: "Fruits", img: "fruits-icon.png", id: "fruitsList" },
    { name: "Vegetables", img: "vegetables-icon.png", id: "vegetablesList" }
];

let categorySection = document.getElementById("categories");
categories.forEach(category => {
    let div = document.createElement("div");
    div.classList.add("category");
    div.innerHTML = `<img src="${category.img}" alt="${category.name} icon">
        <h2>${category.name}</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="${category.id}"></tbody>
        </table>`;
    categorySection.appendChild(div);
});

function showToast(message) {
    let toast = document.getElementById("toast");
    toast.textContent = message;
    toast.style.display = "block";
    setTimeout(() => toast.style.display = "none", 2000);
}

// function addItem() {
//     let itemName = document.getElementById("itemName").value;
//     let itemQuantity = document.getElementById("itemQuantity").value;
//     let itemPrice = document.getElementById("itemPrice").value;
//     let itemCategory = document.getElementById("itemCategory").value;

//     fetch("add_item.php", {
//         method: "POST",
//         headers: { "Content-Type": "application/x-www-form-urlencoded" },
//         body: `item_name=${itemName}&quantity=${itemQuantity}&price=${itemPrice}&category=${itemCategory}`
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === "success") {
//             alert(data.message);
//             location.reload(); // Refresh to show new item
//         } else {
//             alert(data.message);
//         }
//     });
// }

function editItem(button) {
    let row = button.parentElement.parentElement;
    let name = row.cells[0].textContent;
    let quantity = row.cells[1].textContent;
    let price = row.cells[2].textContent;

    document.getElementById("itemName").value = name;
    document.getElementById("itemQuantity").value = quantity;
    document.getElementById("itemPrice").value = price;

    deleteItem(button);
}

function deleteItem(button) {
    let row = button.parentElement.parentElement;
    row.remove();
}

function searchItem() {
    let searchTerm = document.getElementById("search").value.toLowerCase();
    
    categories.forEach(category => {
        let tableBody = document.getElementById(category.id);
        let rows = tableBody.getElementsByTagName("tr");

        for (let row of rows) {
            let itemName = row.cells[0].textContent.toLowerCase();
            if (itemName.includes(searchTerm)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    });
}