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
/* =========================================================
   PRINT RESCUE REPORT
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const printButton =
        document.getElementById("printRescueReportBtn");

    if (printButton) {

        printButton.addEventListener(
            "click",
            function () {

                window.print();
            }
        );
    }
});
/*
|--------------------------------------------------------------------------
| ADMIN RESOURCE REQUEST - AJAX LIVE SEARCH
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById(
            "resourceRequestSearch"
        );

    const tableBody =
        document.getElementById(
            "resourceRequestTableBody"
        );

    const searchMessage =
        document.getElementById(
            "resourceSearchMessage"
        );


    /*
    |--------------------------------------------------------------------------
    | Stop if this is not the Resource Request page
    |--------------------------------------------------------------------------
    */

    if (
        !searchInput ||
        !tableBody ||
        !searchMessage
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Safe text helper
    |--------------------------------------------------------------------------
    */

    function createCell(text) {

        const td =
            document.createElement("td");

        td.textContent =
            text ?? "N/A";

        return td;
    }


    /*
    |--------------------------------------------------------------------------
    | Convert database words
    | currently_rescuing → Currently Rescuing
    |--------------------------------------------------------------------------
    */

    function formatText(value) {

        if (!value) {
            return "N/A";
        }

        return value
            .replaceAll("_", " ")
            .replace(/\b\w/g, function (letter) {
                return letter.toUpperCase();
            });
    }


    /*
    |--------------------------------------------------------------------------
    | DISPLAY SEARCH RESULTS USING DOM
    |--------------------------------------------------------------------------
    */

    function displayRequests(requests) {

        /*
         * Remove old table rows
         */
        tableBody.innerHTML = "";


        if (!requests.length) {

            const row =
                document.createElement("tr");

            const cell =
                document.createElement("td");

            cell.colSpan = 8;

            cell.textContent =
                "No resource requests found.";

            row.appendChild(cell);

            tableBody.appendChild(row);

            return;
        }


        requests.forEach(function (request) {

            const row =
                document.createElement("tr");


            /*
             * ID
             */

            row.appendChild(
                createCell(
                    "#" + request.id
                )
            );


            /*
             * Volunteer
             */

            row.appendChild(
                createCell(
                    request.volunteer_name
                    ?? "N/A"
                )
            );


            /*
             * Resource Type
             */

            row.appendChild(
                createCell(
                    formatText(
                        request.resource_type
                    )
                )
            );


            /*
             * Quantity
             */

            row.appendChild(
                createCell(
                    request.quantity
                    ?? "0"
                )
            );


            /*
             * Availability
             */

            row.appendChild(
                createCell(
                    formatText(
                        request.availability_status
                    )
                )
            );


            /*
             * Status
             */

            const statusCell =
                document.createElement("td");

            const statusBadge =
                document.createElement("span");

            statusBadge.className =
                "status-badge";

            statusBadge.textContent =
                formatText(
                    request.status
                );

            statusCell.appendChild(
                statusBadge
            );

            row.appendChild(
                statusCell
            );


            /*
             * Created Date
             */

            row.appendChild(
                createCell(
                    request.created_at
                    ?? "N/A"
                )
            );


            /*
             * Review Button
             */

            const actionCell =
                document.createElement("td");

            const reviewLink =
                document.createElement("a");

            reviewLink.className =
                "btn btn-primary";

            reviewLink.textContent =
                "Review";

            reviewLink.href =
                "index.php?page=admin-resource-request-view&id="
                + encodeURIComponent(
                    request.id
                );

            actionCell.appendChild(
                reviewLink
            );

            row.appendChild(
                actionCell
            );


            /*
             * Add row to table
             */

            tableBody.appendChild(row);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX SEARCH
    |--------------------------------------------------------------------------
    */

    let searchTimer;


    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(
                searchTimer
            );


            const searchText =
                searchInput.value.trim();


            /*
             * Small delay so every keyboard press
             * does not immediately call PHP.
             */

            searchTimer = setTimeout(
                function () {

                    searchMessage.textContent =
                        "Searching...";


                    fetch(
                        "index.php?page=admin-resource-request-search&search="
                        + encodeURIComponent(
                            searchText
                        )
                    )

                        .then(function (response) {

                            if (!response.ok) {
                                throw new Error(
                                    "Request failed."
                                );
                            }

                            return response.json();
                        })

                        .then(function (result) {

                            if (!result.success) {

                                searchMessage.textContent =
                                    result.message
                                    ?? "Search failed.";

                                displayRequests([]);

                                return;
                            }


                            /*
                             * DOM update without page reload
                             */

                            displayRequests(
                                result.data
                            );


                            searchMessage.textContent =
                                result.count
                                + " request(s) found";
                        })

                        .catch(function (error) {

                            console.error(
                                error
                            );

                            searchMessage.textContent =
                                "Unable to search resource requests.";
                        });

                },
                300
            );
        }
    );

});