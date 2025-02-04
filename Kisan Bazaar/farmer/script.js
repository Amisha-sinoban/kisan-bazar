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