document.addEventListener('DOMContentLoaded', () => {
    const itemPriceInput = document.getElementById('item-price');
    const itemQuantityInput = document.getElementById('item-quantity');
    const logisticFeesInput = document.getElementById('logistic-fees');
    const platformFeesInput = document.getElementById('platform-fees');
    const totalPriceSpan = document.getElementById('total-price');
    const totalProductPriceSpan = document.getElementById('total-product-price');

    function calculateTotalPrice() {
        const itemPrice = parseFloat(itemPriceInput.value);
        const itemQuantity = parseInt(itemQuantityInput.value);
        const totalPrice = itemPrice * itemQuantity;
        totalPriceSpan.textContent = totalPrice.toFixed(2);
        calculateTotalProductPrice(totalPrice);
    }

    function calculateTotalProductPrice(totalPrice) {
        const logisticFees = parseFloat(logisticFeesInput.value);
        const platformFees = parseFloat(platformFeesInput.value);
        const totalProductPrice = totalPrice + logisticFees + platformFees;
        totalProductPriceSpan.textContent = totalProductPrice.toFixed(2);
    }

    itemPriceInput.addEventListener('input', calculateTotalPrice);
    itemQuantityInput.addEventListener('input', calculateTotalPrice);
    logisticFeesInput.addEventListener('input', () => calculateTotalProductPrice(parseFloat(totalPriceSpan.textContent)));
    platformFeesInput.addEventListener('input', () => calculateTotalProductPrice(parseFloat(totalPriceSpan.textContent)));

    // Initial calculation
    calculateTotalPrice();
});