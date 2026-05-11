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

        //  TRIGGER CATEGORY CHANGE ON PAGE LOAD
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
      
    //  FORECAST PAGE LOGIC 
    const canvas = document.getElementById("salesChart");

if (canvas) {

    const labels = JSON.parse(canvas.dataset.labels);
    const data = JSON.parse(canvas.dataset.values);

    const ctx = canvas.getContext("2d");

    /*
    ==========================================
    GRADIENT BACKGROUND
    ==========================================
    */

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);

    gradient.addColorStop(0, "rgba(54, 162, 235, 0.45)");
    gradient.addColorStop(1, "rgba(54, 162, 235, 0.02)");

    /*
    ==========================================
    MODERN CHART
    ==========================================
    */

    new Chart(ctx, {

        type: "line",

        data: {

            labels: labels,

            datasets: [{

                label: "Monthly Sales Trend",

                data: data,

                fill: true,

                backgroundColor: gradient,

                borderColor: "#36A2EB",

                borderWidth: 3,

                tension: 0.4,

                pointBackgroundColor: "#36A2EB",

                pointBorderColor: "#ffffff",

                pointBorderWidth: 2,

                pointRadius: 5,

                pointHoverRadius: 8,

                hoverBorderWidth: 3

            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    labels: {

                        color: "#333",

                        font: {

                            size: 14,

                            weight: "bold"
                        }
                    }
                }
            },

            scales: {

                x: {

                    grid: {

                        display: false
                    },

                    ticks: {

                        color: "#555"
                    }
                },

                y: {

                    beginAtZero: true,

                    grid: {

                        color: "rgba(0,0,0,0.05)"
                    },

                    ticks: {

                        color: "#555"
                    }
                }
            }
        }
    });
}

 

});