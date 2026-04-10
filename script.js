document.addEventListener("DOMContentLoaded", function () {

    //  SALES PAGE LOGIC 
    const category = document.getElementById("category");
    const product = document.getElementById("product");

    if (category && product) {

        // CATEGORY CHANGE → LOAD PRODUCTS
        category.addEventListener("change", function () {

            let category_id = this.value;

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "get_products.php?category_id=" + category_id, true);

            xhr.onload = function () {
                console.log(this.responseText);
                if (this.status == 200) {
                    product.innerHTML = this.responseText;

                    // ✅ AUTO SELECT FIRST PRODUCT
                    if (product.options.length > 0) {
                        product.selectedIndex = 0;

                        // ✅ TRIGGER CHANGE EVENT
                        product.dispatchEvent(new Event("change"));
                    }
                }
            };

            xhr.send();
        });

        // ✅🔥 NEW FIX: TRIGGER CATEGORY CHANGE ON PAGE LOAD
        // This ensures products + price load immediately
        if (category.value) {
            category.dispatchEvent(new Event("change"));
        }
    }

    // PRODUCT CHANGE → SET NAME + PRICE
    if (product) {
        product.addEventListener("change", function () {

            let selectedOption = this.options[this.selectedIndex];

            // set product name
            let input = document.getElementById("product_name");
            if (input) {
                input.value = selectedOption.text;
            }

            // set unit price
            let price = selectedOption.getAttribute("data-price");
            let priceInput = document.getElementById("unit_price");

            if (priceInput) {
                priceInput.value = price;
            }
        });
    }

    //  FORECAST PAGE LOGIC (UNCHANGED ✅)
    const canvas = document.getElementById("salesChart");

    if (canvas) {
        const labels = JSON.parse(canvas.dataset.labels);
        const data = JSON.parse(canvas.dataset.values);

        const ctx = canvas.getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Monthly Sales",
                    data: data,
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});