
 document.addEventListener("DOMContentLoaded", function () {

    //  SALES PAGE LOGIC 
    const category = document.getElementById("category");
    const product = document.getElementById("product");

    if (category && product) {
        category.addEventListener("change", function () {

            let category_id = this.value;

            let xhr = new XMLHttpRequest();

            xhr.open("GET", "get_products.php?category_id=" + category_id, true);

            xhr.onload = function () {
                console.log(this.responseText);
                if (this.status == 200) {
                    product.innerHTML = this.responseText;
                }
            };

            xhr.send();
        });
    }


    //  FORECAST PAGE LOGIC
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


    // when product selected → auto fill name
    const product = document.getElementById('product');

    if(product){
        product.addEventListener("change", function(){

        let productName = this.options[this.selectedIndex].text;
        let input = document.getElementById("product_name");
        if(input){
            input.value = productName;


        }

        
        

    });

};


// when product selected → get price
if(product){
    product.addEventListener("change", function(){

    let product_id = this.value;

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "get_price.php?product_id=" + product_id, true);

    xhr.onload = function(){
        if(this.status == 200){
            // set price to input
            let priceInput = document.getElementById("unit_price");
            if(priceInput){
                priceInput.value = this.responseText;
            }
        }
    }

    xhr.send();

});

}


document.addEventListener("DOMContentLoaded", function(){

    //  category change → load products
    // (your existing working code)

    //  product change → set price
    const product = document.getElementById("product");

    if(product){
        product.addEventListener("change", function(){

            let selectedOption = this.options[this.selectedIndex];
            let price = selectedOption.getAttribute("data-price");

            document.getElementById("unit_price").value = price;
        });
    }

});
