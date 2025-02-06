document.addEventListener('DOMContentLoaded', () => {
    const itemPriceInput = document.getElementById('item-price');
    const itemQuantityInput = document.getElementById('item-quantity');
    const logisticFeesSpan = document.getElementById('logistic-fees');
    const platformFeesSpan = document.getElementById('platform-fees');
    const totalPriceSpan = document.getElementById('total-price');
    const totalProductPriceSpan = document.getElementById('total-product-price');
    const negotiationPriceInput = document.getElementById('negotiation-price');
    const negotiationValueSpan = document.getElementById('negotiation-value');
    const negotiationButton = document.getElementById('negotiate-button');
    const negotiationResult = document.getElementById('negotiation-result');

    const PLATFORM_FEES = 3;
    const DISTANCE = 4; // Example distance in km (this would be determined programmatically in a real scenario)

    function calculateTotalPrice() {
        const itemPrice = parseFloat(itemPriceInput.value);
        const itemQuantity = parseInt(itemQuantityInput.value);
        const totalPrice = itemPrice * itemQuantity;
        totalPriceSpan.textContent = totalPrice.toFixed(2);
        calculateLogisticFees(totalPrice);
    }

    function calculateLogisticFees(totalPrice) {
        let logisticFees = DISTANCE * 10;
        if (DISTANCE > 3) {
            logisticFees += 5;
        }
        logisticFeesSpan.textContent = logisticFees.toFixed(2);
        calculateTotalProductPrice(totalPrice, logisticFees);
    }

    function calculateTotalProductPrice(totalPrice, logisticFees) {
        const platformFees = PLATFORM_FEES;
        platformFeesSpan.textContent = platformFees.toFixed(2);
        const totalProductPrice = totalPrice + logisticFees + platformFees;
        totalProductPriceSpan.textContent = totalProductPrice.toFixed(2);
    }

    itemPriceInput.addEventListener('input', calculateTotalPrice);
    itemQuantityInput.addEventListener('input', calculateTotalPrice);

    negotiationPriceInput.addEventListener('input', () => {
        negotiationValueSpan.textContent = negotiationPriceInput.value;
    });

    negotiationButton.addEventListener('click', () => {
        const negotiationPrice = parseFloat(negotiationPriceInput.value);
        const totalProductPrice = parseFloat(totalProductPriceSpan.textContent);
        if (negotiationPrice >= totalProductPrice) {
            negotiationResult.textContent = "Your offer is accepted!";
            negotiationResult.style.color = "green";
        } else {
            negotiationResult.textContent = "Your offer is too low. Please increase your offer.";
            negotiationResult.style.color = "red";
        }
    });

    // Initial calculation
    calculateTotalPrice();
});