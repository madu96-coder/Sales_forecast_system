//demo chart adding


document.addEventListener("DOMContentLoaded", function () {

    console.log("Dashboard JS loaded "); // debug

    // SALES CHART
    const salesCanvas = document.getElementById("salesChart");

    if (salesCanvas) {
        const ctx1 = salesCanvas.getContext("2d");

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Sales',
                    data: [5000, 8000, 6000, 9000, 12000],
                    borderWidth: 2
                }]
            }
        });

    } else {
        console.log("salesChart NOT found ❌");
    }

    // PRODUCT CHART
    const productCanvas = document.getElementById("productChart");

    if (productCanvas) {
        const ctx2 = productCanvas.getContext("2d");

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C'],
                datasets: [{
                    label: 'Products',
                    data: [50, 30, 70],
                    borderWidth: 1
                }]
            }
        });

    } else {
        console.log("productChart NOT found ❌");
    }

});