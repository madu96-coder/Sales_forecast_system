document.addEventListener("DOMContentLoaded", function () {

    console.log("JS LOADED");

    const productSelect = document.getElementById("productSelect");
    const newProductFields = document.getElementById("newProductFields");
    const newName = document.getElementById("new_name");
    const newPrice = document.getElementById("new_price");

    //  safety check 
    if (!productSelect || !newProductFields) {
        console.error("Elements not found! Check IDs in HTML");
        return;
    }

    productSelect.addEventListener("change", function () {

        if (this.value === "new") {
            newProductFields.style.display = "block";

            if (newName) newName.setAttribute("required", "required");
            if (newPrice) newPrice.setAttribute("required", "required");

        } else {
            newProductFields.style.display = "none";

            if (newName) {
                newName.removeAttribute("required");
                newName.value = "";
            }

            if (newPrice) {
                newPrice.removeAttribute("required");
                newPrice.value = "";
            }
        }
    });

});