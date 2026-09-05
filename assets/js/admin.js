document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById("notificationSearch");

    const notificationRows =
        document.querySelectorAll(".notification-row");

    const noResultMessage =
        document.getElementById("noSearchResult");


    if (!searchInput) {
        return;
    }


    searchInput.addEventListener("input", function () {

        const searchValue =
            searchInput.value.toLowerCase().trim();

        let visibleCount = 0;


        notificationRows.forEach(function (row) {

            const rowText =
                row.textContent.toLowerCase();

            if (rowText.includes(searchValue)) {

                row.style.display = "";
                visibleCount++;

            } else {

                row.style.display = "none";
            }

        });


        if (noResultMessage) {

            if (
                visibleCount === 0 &&
                searchValue !== ""
            ) {
                noResultMessage.style.display = "block";

            } else {

                noResultMessage.style.display = "none";
            }

        }

    });

});