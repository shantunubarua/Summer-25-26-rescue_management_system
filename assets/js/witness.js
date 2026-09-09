document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById("witnessReportSearch");

    const tableBody =
        document.getElementById("witnessReportTableBody");

    const countElement =
        document.getElementById("witnessSearchCount");

    const messageElement =
        document.getElementById("witnessSearchMessage");


    if (
        !searchInput ||
        !tableBody ||
        !countElement ||
        !messageElement
    ) {
        return;
    }


    let searchTimer = null;


    /*
    |--------------------------------------------------------------------------
    | SEARCH INPUT
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(searchTimer);

            const keyword =
                searchInput.value.trim();


            messageElement.textContent =
                "Searching...";


            searchTimer = setTimeout(
                function () {

                    searchWitnessReports(keyword);

                },
                300
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | AJAX SEARCH
    |--------------------------------------------------------------------------
    */

    function searchWitnessReports(keyword)
    {

        const url =
            "index.php?page=witness-report-search&q=" +
            encodeURIComponent(keyword);


        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    "Search request failed."
                );
            }

            return response.json();
        })
        .then(function (result) {

            if (!result.success) {

                throw new Error(
                    result.message ||
                    "Unable to search reports."
                );
            }


            updateWitnessReportTable(
                result.data
            );


            countElement.textContent =
                result.count;


            if (result.count === 0) {

                messageElement.textContent =
                    "No matching incident reports found.";

            } else {

                messageElement.textContent =
                    "Search completed.";
            }

        })
        .catch(function (error) {

            console.error(error);

            messageElement.textContent =
                "Unable to load search results.";
        });
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TABLE USING DOM
    |--------------------------------------------------------------------------
    */

    function updateWitnessReportTable(reports)
    {

        /*
        |--------------------------------------------------------------------------
        | Clear Old Rows
        |--------------------------------------------------------------------------
        */

        tableBody.textContent = "";


        /*
        |--------------------------------------------------------------------------
        | No Results
        |--------------------------------------------------------------------------
        */

        if (
            !Array.isArray(reports) ||
            reports.length === 0
        ) {

            const row =
                document.createElement("tr");

            const cell =
                document.createElement("td");


            cell.colSpan = 8;

            cell.textContent =
                "No matching incident reports found.";


            row.appendChild(cell);

            tableBody.appendChild(row);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Result Rows
        |--------------------------------------------------------------------------
        */

        reports.forEach(function (report) {

            const row =
                document.createElement("tr");


            /*
            |--------------------------------------------------------------------------
            | ID
            |--------------------------------------------------------------------------
            */

            const idCell =
                document.createElement("td");

            idCell.textContent =
                report.id ?? "";

            row.appendChild(idCell);


            /*
            |--------------------------------------------------------------------------
            | TITLE
            |--------------------------------------------------------------------------
            */

            const titleCell =
                document.createElement("td");

            titleCell.textContent =
                report.title ?? "";

            row.appendChild(titleCell);


            /*
            |--------------------------------------------------------------------------
            | INCIDENT TYPE
            |--------------------------------------------------------------------------
            */

            const typeCell =
                document.createElement("td");

            typeCell.textContent =
                capitalizeText(
                    report.incident_type ?? ""
                );

            row.appendChild(typeCell);


            /*
            |--------------------------------------------------------------------------
            | DAMAGE LEVEL
            |--------------------------------------------------------------------------
            */

            const damageCell =
                document.createElement("td");

            damageCell.textContent =
                capitalizeText(
                    report.damage_level ??
                    "Not specified"
                );

            row.appendChild(damageCell);


            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */

            const locationCell =
                document.createElement("td");

            locationCell.textContent =
                report.location ?? "";

            row.appendChild(locationCell);


            /*
            |--------------------------------------------------------------------------
            | INCIDENT DATE
            |--------------------------------------------------------------------------
            */

            const dateCell =
                document.createElement("td");

            dateCell.textContent =
                report.incident_date ?? "";

            row.appendChild(dateCell);


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            const statusCell =
                document.createElement("td");

            statusCell.textContent =
                capitalizeText(
                    report.status ?? "pending"
                );

            row.appendChild(statusCell);


            /*
            |--------------------------------------------------------------------------
            | ACTION
            |--------------------------------------------------------------------------
            */

            const actionCell =
                document.createElement("td");


            /*
            |--------------------------------------------------------------------------
            | View Link
            |--------------------------------------------------------------------------
            */

            const viewLink =
                document.createElement("a");

            viewLink.href =
                "index.php?page=witness-report-view&id=" +
                encodeURIComponent(report.id);

            viewLink.textContent =
                "View";


            actionCell.appendChild(
                viewLink
            );


            actionCell.appendChild(
                document.createTextNode(" ")
            );


            /*
            |--------------------------------------------------------------------------
            | Edit Link
            |--------------------------------------------------------------------------
            */

            const editLink =
                document.createElement("a");

            editLink.href =
                "index.php?page=witness-report-edit&id=" +
                encodeURIComponent(report.id);

            editLink.textContent =
                "Edit";


            actionCell.appendChild(
                editLink
            );


            actionCell.appendChild(
                document.createTextNode(" ")
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Form
            |--------------------------------------------------------------------------
            */

            const deleteForm =
                document.createElement("form");

            deleteForm.method =
                "POST";

            deleteForm.action =
                "index.php?page=witness-report-delete";

            deleteForm.style.display =
                "inline";


            const hiddenInput =
                document.createElement("input");

            hiddenInput.type =
                "hidden";

            hiddenInput.name =
                "id";

            hiddenInput.value =
                report.id;


            const deleteButton =
                document.createElement("button");

            deleteButton.type =
                "submit";

            deleteButton.textContent =
                "Delete";


            deleteForm.appendChild(
                hiddenInput
            );

            deleteForm.appendChild(
                deleteButton
            );


            deleteForm.addEventListener(
                "submit",
                function (event) {

                    const confirmed =
                        window.confirm(
                            "Are you sure you want to delete this report?"
                        );


                    if (!confirmed) {

                        event.preventDefault();
                    }
                }
            );


            actionCell.appendChild(
                deleteForm
            );


            row.appendChild(
                actionCell
            );


            /*
            |--------------------------------------------------------------------------
            | Add Row
            |--------------------------------------------------------------------------
            */

            tableBody.appendChild(
                row
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CAPITALIZE TEXT
    |--------------------------------------------------------------------------
    */

    function capitalizeText(value)
    {

        const text =
            String(value);

        if (text.length === 0) {
            return "";
        }

        return (
            text.charAt(0).toUpperCase() +
            text.slice(1)
        );
    }

});