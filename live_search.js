// 🔥 CLEAN LIVE SEARCH (FINAL VERSION)

document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("searchInput");
    const tableBody = document.getElementById("tableBody");
    const suggestions = document.getElementById("suggestions"); // from HTML

    // safety check
    if (!searchInput || !tableBody || !suggestions) return;

    searchInput.addEventListener("keyup", function () {

        let query = this.value.trim();

        // 🔥 clear if empty
        if (query.length === 0) {
            suggestions.innerHTML = "";
            location.reload(); // reload full table
            return;
        }

        let xhr = new XMLHttpRequest();

        // 🔥 MUST MATCH PHP PARAM
        xhr.open("GET", "live_search.php?q=" + encodeURIComponent(query), true);

        xhr.onload = function () {
            if (this.status === 200) {

                // 🔥 SPLIT RESPONSE (IMPORTANT)
                let data = JSON.parse(this.responseText);

                // ✅ suggestions (names only)
                suggestions.innerHTML = data.suggestions;

                // ✅ table update
                tableBody.innerHTML = data.table;

                // 🔥 CLICK TO SELECT
                document.querySelectorAll(".item").forEach(item => {
                    item.addEventListener("click", function () {
                        searchInput.value = this.innerText;
                        suggestions.innerHTML = "";
                    });
                });
            }
        };

        xhr.send();
    });

    // 🔥 hide suggestions when clicking outside
    document.addEventListener("click", function (e) {
        if (!e.target.closest("#searchInput")) {
            suggestions.innerHTML = "";
        }
    });

});