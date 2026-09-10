/*
|--------------------------------------------------------------------------
| ADMIN NOTIFICATION - AJAX LIVE SEARCH
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById(
            "notificationSearch"
        );

    const tableBody =
        document.getElementById(
            "notificationTableBody"
        );

    const countElement =
        document.getElementById(
            "notificationCount"
        );

    const searchMessage =
        document.getElementById(
            "notificationSearchMessage"
        );

    const csrfTokenInput =
        document.getElementById(
            "notificationCsrfToken"
        );


    /*
    |--------------------------------------------------------------------------
    | Stop if this is not Notification page
    |--------------------------------------------------------------------------
    */

    if (
        !searchInput ||
        !tableBody ||
        !countElement ||
        !searchMessage ||
        !csrfTokenInput
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Format database text
    |--------------------------------------------------------------------------
    */

    function formatText(value) {

        if (!value) {
            return "";
        }

        return String(value)
            .replaceAll("_", " ")
            .replace(/\b\w/g, function (letter) {
                return letter.toUpperCase();
            });
    }


    /*
    |--------------------------------------------------------------------------
    | Create normal table cell
    |--------------------------------------------------------------------------
    */

    function createCell(value) {

        const cell =
            document.createElement("td");

        cell.textContent =
            value ?? "";

        return cell;
    }


    /*
    |--------------------------------------------------------------------------
    | Display Notification Results
    |--------------------------------------------------------------------------
    */

    function displayNotifications(notifications) {

        tableBody.textContent = "";


        if (
            !Array.isArray(notifications) ||
            notifications.length === 0
        ) {

            const row =
                document.createElement("tr");

            const cell =
                document.createElement("td");

            cell.colSpan = 9;

            cell.textContent =
                "No matching notifications found.";

            row.appendChild(cell);

            tableBody.appendChild(row);

            return;
        }


        notifications.forEach(
            function (notification) {

                const row =
                    document.createElement("tr");


                /*
                |--------------------------------------------------------------------------
                | ID
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        notification.id ?? ""
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | TITLE
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        notification.title ?? ""
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | MESSAGE
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        notification.message ?? ""
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | ALERT TYPE
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        formatText(
                            notification.alert_type
                        )
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | TARGET AUDIENCE
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        formatText(
                            notification.target_audience
                            ?? "all"
                        )
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        formatText(
                            notification.status
                        )
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | CREATED BY
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        notification.admin_name
                        ?? ""
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | CREATED AT
                |--------------------------------------------------------------------------
                */

                row.appendChild(
                    createCell(
                        notification.created_at
                        ?? ""
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | ACTIONS
                |--------------------------------------------------------------------------
                */

                const actionCell =
                    document.createElement("td");


                const editLink =
                    document.createElement("a");

                editLink.href =
                    "index.php?page=notification-edit&id=" +
                    encodeURIComponent(
                        notification.id
                    );

                editLink.textContent =
                    "Edit";

                actionCell.appendChild(
                    editLink
                );


                actionCell.appendChild(
                    document.createTextNode(
                        " | "
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | DELETE FORM - POST + CSRF
                |--------------------------------------------------------------------------
                */

                const deleteForm =
                    document.createElement("form");

                deleteForm.method =
                    "POST";

                deleteForm.action =
                    "index.php?page=notification-delete";

                deleteForm.style.display =
                    "inline";


                const csrfInput =
                    document.createElement("input");

                csrfInput.type =
                    "hidden";

                csrfInput.name =
                    "csrf_token";

                csrfInput.value =
                    csrfTokenInput.value;

                deleteForm.appendChild(
                    csrfInput
                );


                const idInput =
                    document.createElement("input");

                idInput.type =
                    "hidden";

                idInput.name =
                    "notification_id";

                idInput.value =
                    notification.id;

                deleteForm.appendChild(
                    idInput
                );


                const deleteButton =
                    document.createElement("button");

                deleteButton.type =
                    "submit";

                deleteButton.textContent =
                    "Delete";

                deleteForm.appendChild(
                    deleteButton
                );


                deleteForm.addEventListener(
                    "submit",
                    function (event) {

                        const confirmed =
                            confirm(
                                "Are you sure you want to delete this notification?"
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


    /*
    |--------------------------------------------------------------------------
    | AJAX LIVE SEARCH
    |--------------------------------------------------------------------------
    */

    let searchTimer;


    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(
                searchTimer
            );


            const keyword =
                searchInput.value.trim();


            searchTimer =
                setTimeout(
                    function () {

                        searchMessage.textContent =
                            "Searching...";


                        fetch(
                            "index.php?page=notification-search&q=" +
                            encodeURIComponent(
                                keyword
                            )
                        )

                            .then(function (response) {

                                if (!response.ok) {

                                    throw new Error(
                                        "Notification search failed."
                                    );
                                }

                                return response.json();
                            })


                            .then(function (result) {

                                if (
                                    !result.success ||
                                    !Array.isArray(
                                        result.data
                                    )
                                ) {

                                    throw new Error(
                                        "Invalid search response."
                                    );
                                }


                                displayNotifications(
                                    result.data
                                );


                                countElement.textContent =
                                    result.count;


                                if (
                                    result.count === 0
                                ) {

                                    searchMessage.textContent =
                                        "No matching notifications found.";

                                } else {

                                    searchMessage.textContent =
                                        "Showing " +
                                        result.count +
                                        " notification(s).";
                                }
                            })


                            .catch(function (error) {

                                console.error(
                                    error
                                );

                                searchMessage.textContent =
                                    "Unable to search notifications.";
                            });

                    },
                    300
                );
        }
    );

});


/*
=========================================================
PRINT RESCUE REPORT
=========================================================
*/

document.addEventListener("DOMContentLoaded", function () {

    const printButton =
        document.getElementById(
            "printRescueReportBtn"
        );

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


/*
|--------------------------------------------------------------------------
| ADMIN NOTIFICATION - CREATE FORM VALIDATION
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById(
            "notificationCreateForm"
        );

    if (!form) {
        return;
    }


    const titleInput =
        document.getElementById(
            "title"
        );

    const messageInput =
        document.getElementById(
            "message"
        );

    const alertTypeInput =
        document.getElementById(
            "alert_type"
        );

    const audienceInput =
        document.getElementById(
            "target_audience"
        );

    const statusInput =
        document.getElementById(
            "status"
        );

    const validationMessage =
        document.getElementById(
            "notificationValidationMessage"
        );


    form.addEventListener(
        "submit",
        function (event) {

            const title =
                titleInput.value.trim();

            const message =
                messageInput.value.trim();

            const alertType =
                alertTypeInput.value;

            const audience =
                audienceInput.value;

            const status =
                statusInput.value;


            /*
            |--------------------------------------------------------------------------
            | TITLE
            |--------------------------------------------------------------------------
            */

            if (title === "") {

                event.preventDefault();

                showValidationMessage(
                    "Notification title is required."
                );

                titleInput.focus();

                return;
            }


            if (title.length > 150) {

                event.preventDefault();

                showValidationMessage(
                    "Notification title cannot exceed 150 characters."
                );

                titleInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | MESSAGE
            |--------------------------------------------------------------------------
            */

            if (message === "") {

                event.preventDefault();

                showValidationMessage(
                    "Notification message is required."
                );

                messageInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ALERT TYPE
            |--------------------------------------------------------------------------
            */

            const allowedAlertTypes = [
                "normal",
                "important",
                "emergency"
            ];

            if (
                !allowedAlertTypes.includes(
                    alertType
                )
            ) {

                event.preventDefault();

                showValidationMessage(
                    "Please select a valid alert type."
                );

                alertTypeInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | TARGET AUDIENCE
            |--------------------------------------------------------------------------
            */

            const allowedAudiences = [
                "all",
                "volunteer",
                "witness",
                "help_seeker"
            ];

            if (
                !allowedAudiences.includes(
                    audience
                )
            ) {

                event.preventDefault();

                showValidationMessage(
                    "Please select a valid target audience."
                );

                audienceInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            const allowedStatuses = [
                "active",
                "inactive"
            ];

            if (
                !allowedStatuses.includes(
                    status
                )
            ) {

                event.preventDefault();

                showValidationMessage(
                    "Please select a valid notification status."
                );

                statusInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | VALID FORM
            |--------------------------------------------------------------------------
            */

            validationMessage.style.display =
                "none";

            validationMessage.textContent =
                "";
        }
    );


    /*
    |--------------------------------------------------------------------------
    | DISPLAY VALIDATION ERROR
    |--------------------------------------------------------------------------
    */

    function showValidationMessage(message) {

        validationMessage.textContent =
            message;

        validationMessage.style.display =
            "block";

        validationMessage.style.color =
            "red";
    }

});