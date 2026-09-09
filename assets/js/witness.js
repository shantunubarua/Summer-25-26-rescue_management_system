document.addEventListener(
    "DOMContentLoaded",
    function () {

        initWitnessReportSearch();

        initWitnessReportValidation();

    }
);


/*
|--------------------------------------------------------------------------
| WITNESS INCIDENT REPORT AJAX SEARCH
|--------------------------------------------------------------------------
*/

function initWitnessReportSearch()
{
    const searchInput =
        document.getElementById(
            "witnessReportSearch"
        );

    const tableBody =
        document.getElementById(
            "witnessReportTableBody"
        );

    const countElement =
        document.getElementById(
            "witnessSearchCount"
        );

    const messageElement =
        document.getElementById(
            "witnessSearchMessage"
        );


    /*
    |--------------------------------------------------------------------------
    | Search page na hole stop
    |--------------------------------------------------------------------------
    */

    if (
        !searchInput ||
        !tableBody ||
        !countElement ||
        !messageElement
    ) {
        return;
    }


    let searchTimer = null;


    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(
                searchTimer
            );


            const keyword =
                searchInput.value.trim();


            messageElement.textContent =
                "Searching...";


            searchTimer =
                setTimeout(
                    function () {

                        searchWitnessReports(
                            keyword
                        );

                    },
                    300
                );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | AJAX Request
    |--------------------------------------------------------------------------
    */

    function searchWitnessReports(
        keyword
    ) {

        const url =
            "index.php?page=witness-report-search&q=" +
            encodeURIComponent(
                keyword
            );


        fetch(
            url,
            {
                method: "GET",

                headers: {
                    "X-Requested-With":
                        "XMLHttpRequest"
                }
            }
        )
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

            console.error(
                error
            );


            messageElement.textContent =
                "Unable to load search results.";

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Update Table Using DOM
    |--------------------------------------------------------------------------
    */

    function updateWitnessReportTable(
        reports
    ) {

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
                document.createElement(
                    "tr"
                );

            const cell =
                document.createElement(
                    "td"
                );


            cell.colSpan = 8;

            cell.textContent =
                "No matching incident reports found.";


            row.appendChild(
                cell
            );

            tableBody.appendChild(
                row
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Result Rows
        |--------------------------------------------------------------------------
        */

        reports.forEach(
            function (report) {

                const row =
                    document.createElement(
                        "tr"
                    );


                /*
                | ID
                */

                const idCell =
                    document.createElement(
                        "td"
                    );

                idCell.textContent =
                    report.id ?? "";

                row.appendChild(
                    idCell
                );


                /*
                | Title
                */

                const titleCell =
                    document.createElement(
                        "td"
                    );

                titleCell.textContent =
                    report.title ?? "";

                row.appendChild(
                    titleCell
                );


                /*
                | Incident Type
                */

                const typeCell =
                    document.createElement(
                        "td"
                    );

                typeCell.textContent =
                    capitalizeText(
                        report.incident_type
                        ?? ""
                    );

                row.appendChild(
                    typeCell
                );


                /*
                | Damage Level
                */

                const damageCell =
                    document.createElement(
                        "td"
                    );

                damageCell.textContent =
                    capitalizeText(
                        report.damage_level
                        ?? "Not specified"
                    );

                row.appendChild(
                    damageCell
                );


                /*
                | Location
                */

                const locationCell =
                    document.createElement(
                        "td"
                    );

                locationCell.textContent =
                    report.location ?? "";

                row.appendChild(
                    locationCell
                );


                /*
                | Incident Date
                */

                const dateCell =
                    document.createElement(
                        "td"
                    );

                dateCell.textContent =
                    report.incident_date ?? "";

                row.appendChild(
                    dateCell
                );


                /*
                | Status
                */

                const statusCell =
                    document.createElement(
                        "td"
                    );

                statusCell.textContent =
                    capitalizeText(
                        report.status
                        ?? "pending"
                    );

                row.appendChild(
                    statusCell
                );


                /*
                | Actions
                */

                const actionCell =
                    document.createElement(
                        "td"
                    );


                /*
                | View
                */

                const viewLink =
                    document.createElement(
                        "a"
                    );

                viewLink.href =
                    "index.php?page=witness-report-view&id=" +
                    encodeURIComponent(
                        report.id
                    );

                viewLink.textContent =
                    "View";


                actionCell.appendChild(
                    viewLink
                );


                actionCell.appendChild(
                    document.createTextNode(
                        " "
                    )
                );


                /*
                | Edit
                */

                const editLink =
                    document.createElement(
                        "a"
                    );

                editLink.href =
                    "index.php?page=witness-report-edit&id=" +
                    encodeURIComponent(
                        report.id
                    );

                editLink.textContent =
                    "Edit";


                actionCell.appendChild(
                    editLink
                );


                actionCell.appendChild(
                    document.createTextNode(
                        " "
                    )
                );


                /*
                | Delete Form
                */

                const deleteForm =
                    document.createElement(
                        "form"
                    );

                deleteForm.method =
                    "POST";

                deleteForm.action =
                    "index.php?page=witness-report-delete";

                deleteForm.style.display =
                    "inline";


                const hiddenInput =
                    document.createElement(
                        "input"
                    );

                hiddenInput.type =
                    "hidden";

                hiddenInput.name =
                    "id";

                hiddenInput.value =
                    report.id;


                const deleteButton =
                    document.createElement(
                        "button"
                    );

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


                tableBody.appendChild(
                    row
                );
            }
        );
    }
}


/*
|--------------------------------------------------------------------------
| WITNESS INCIDENT REPORT JAVASCRIPT VALIDATION
|--------------------------------------------------------------------------
*/

function initWitnessReportValidation()
{
    const form =
        document.getElementById(
            "witnessReportForm"
        );


    /*
    |--------------------------------------------------------------------------
    | Create report page na hole stop
    |--------------------------------------------------------------------------
    */

    if (!form) {
        return;
    }


    const title =
        document.getElementById(
            "title"
        );

    const description =
        document.getElementById(
            "description"
        );

    const damageLevel =
        document.getElementById(
            "damage_level"
        );

    const incidentType =
        document.getElementById(
            "incident_type"
        );

    const location =
        document.getElementById(
            "location"
        );

    const incidentDate =
        document.getElementById(
            "incident_date"
        );

    const evidenceFile =
        document.getElementById(
            "evidence_file"
        );


    /*
    |--------------------------------------------------------------------------
    | Validation Message
    |--------------------------------------------------------------------------
    */

    const validationMessage =
        document.createElement(
            "p"
        );


    validationMessage.id =
        "witnessValidationMessage";

    validationMessage.setAttribute(
        "role",
        "alert"
    );


    form.parentNode.insertBefore(
        validationMessage,
        form
    );


    /*
    |--------------------------------------------------------------------------
    | Form Submit Validation
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        "submit",
        function (event) {

            validationMessage.textContent =
                "";


            /*
            |--------------------------------------------------------------------------
            | Required Fields
            |--------------------------------------------------------------------------
            */

            if (
                title.value.trim() === "" ||
                description.value.trim() === "" ||
                damageLevel.value === "" ||
                incidentType.value === "" ||
                location.value.trim() === "" ||
                incidentDate.value === ""
            ) {

                event.preventDefault();

                validationMessage.textContent =
                    "Please complete all required incident fields.";

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Damage Level Validation
            |--------------------------------------------------------------------------
            */

            const allowedDamageLevels = [
                "low",
                "medium",
                "high",
                "critical"
            ];


            if (
                !allowedDamageLevels.includes(
                    damageLevel.value
                )
            ) {

                event.preventDefault();

                validationMessage.textContent =
                    "Please select a valid damage level.";

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Incident Type Validation
            |--------------------------------------------------------------------------
            */

            const allowedIncidentTypes = [
                "accident",
                "fire",
                "flood",
                "medical",
                "other"
            ];


            if (
                !allowedIncidentTypes.includes(
                    incidentType.value
                )
            ) {

                event.preventDefault();

                validationMessage.textContent =
                    "Please select a valid incident type.";

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Evidence File Validation
            |--------------------------------------------------------------------------
            */

            if (
                evidenceFile &&
                evidenceFile.files.length > 0
            ) {

                const file =
                    evidenceFile.files[0];


                const allowedExtensions = [
                    "jpg",
                    "jpeg",
                    "png",
                    "pdf"
                ];


                const fileName =
                    file.name.toLowerCase();


                const extension =
                    fileName.includes(".")
                        ? fileName
                            .split(".")
                            .pop()
                        : "";


                if (
                    !allowedExtensions.includes(
                        extension
                    )
                ) {

                    event.preventDefault();

                    validationMessage.textContent =
                        "Evidence must be JPG, JPEG, PNG or PDF.";

                    return;
                }


                const maxFileSize =
                    5 * 1024 * 1024;


                if (
                    file.size >
                    maxFileSize
                ) {

                    event.preventDefault();

                    validationMessage.textContent =
                        "Evidence file must be less than 5 MB.";

                    return;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Validation Passed
            |--------------------------------------------------------------------------
            */

            validationMessage.textContent =
                "";
        }
    );
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