document.addEventListener(
    "DOMContentLoaded",
    function () {

        const searchInput =
            document.getElementById(
                "helpSeekerRequestSearch"
            );

        const requestList =
            document.getElementById(
                "helpSeekerRequestList"
            );

        const countElement =
            document.getElementById(
                "helpSeekerRequestCount"
            );

        const messageElement =
            document.getElementById(
                "helpSeekerSearchMessage"
            );


        if (
            !searchInput ||
            !requestList ||
            !countElement ||
            !messageElement
        ) {
            return;
        }


        let searchTimer = null;


        /*
        |--------------------------------------------------------------------------
        | LIVE SEARCH
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            "input",
            function () {

                clearTimeout(searchTimer);

                searchTimer =
                    setTimeout(
                        function () {

                            searchRequests(
                                searchInput.value
                            );

                        },
                        300
                    );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | AJAX REQUEST
        |--------------------------------------------------------------------------
        */

        function searchRequests(keyword)
        {
            messageElement.textContent =
                "Searching...";

            fetch(
                "index.php?page=helpseeker-request-search&q=" +
                encodeURIComponent(keyword),
                {
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

                    if (
                        !result.success ||
                        !Array.isArray(result.data)
                    ) {
                        throw new Error(
                            "Invalid search response."
                        );
                    }


                    updateRequestList(
                        result.data
                    );


                    countElement.textContent =
                        result.count;


                    if (result.count === 0) {

                        messageElement.textContent =
                            "No matching emergency requests found.";

                    } else {

                        messageElement.textContent =
                            "Showing " +
                            result.count +
                            " request(s).";
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
        | UPDATE REQUEST CARDS
        |--------------------------------------------------------------------------
        */

        function updateRequestList(requests)
        {
            requestList.textContent = "";


            if (
                !Array.isArray(requests) ||
                requests.length === 0
            ) {

                const emptyCard =
                    document.createElement("div");

                emptyCard.className =
                    "card";


                const title =
                    document.createElement("h3");

                title.textContent =
                    "No Matching Requests";


                const text =
                    document.createElement("p");

                text.textContent =
                    "No emergency requests matched your search.";


                emptyCard.appendChild(title);
                emptyCard.appendChild(text);

                requestList.appendChild(
                    emptyCard
                );

                return;
            }


            requests.forEach(
                function (request) {

                    const card =
                        document.createElement(
                            "div"
                        );

                    card.className =
                        "card";


                    /*
                    |--------------------------------------------------------------------------
                    | EMERGENCY TYPE
                    |--------------------------------------------------------------------------
                    */

                    const title =
                        document.createElement(
                            "h3"
                        );

                    title.textContent =
                        capitalizeText(
                            request.emergency_type
                            ?? ""
                        );

                    card.appendChild(title);


                    /*
                    |--------------------------------------------------------------------------
                    | BASIC INFORMATION
                    |--------------------------------------------------------------------------
                    */

                    appendDetail(
                        card,
                        "Request ID:",
                        request.id ?? ""
                    );

                    appendDetail(
                        card,
                        "Location:",
                        request.location ?? ""
                    );

                    appendDetail(
                        card,
                        "Description:",
                        request.description ?? ""
                    );

                    appendDetail(
                        card,
                        "Priority:",
                        capitalizeText(
                            request.priority ?? ""
                        )
                    );

                    appendDetail(
                        card,
                        "Victim Type:",
                        capitalizeText(
                            request.victim_type ?? ""
                        )
                    );


                    if (
                        request.victim_information
                    ) {

                        appendDetail(
                            card,
                            "Victim Information:",
                            request.victim_information
                        );
                    }


                    appendDetail(
                        card,
                        "Victim Count:",
                        request.victim_count ?? ""
                    );

                    appendDetail(
                        card,
                        "Contact Information:",
                        request.contact_information
                        ?? ""
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    appendStatus(
                        card,
                        request.status
                        ?? "pending"
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ACCEPTED AT
                    |--------------------------------------------------------------------------
                    */

                    if (request.accepted_at) {

                        appendDetail(
                            card,
                            "Accepted At:",
                            request.accepted_at
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREATED AT
                    |--------------------------------------------------------------------------
                    */

                    appendDetail(
                        card,
                        "Created At:",
                        request.created_at ?? ""
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | VIEW DETAILS
                    |--------------------------------------------------------------------------
                    */

                    const viewParagraph =
                        document.createElement(
                            "p"
                        );

                    const viewLink =
                        document.createElement(
                            "a"
                        );

                    viewLink.href =
                        "index.php?page=helpseeker-request-view&id=" +
                        encodeURIComponent(
                            request.id
                        );

                    viewLink.textContent =
                        "View Details";

                    viewParagraph.appendChild(
                        viewLink
                    );

                    card.appendChild(
                        viewParagraph
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | FEEDBACK
                    |--------------------------------------------------------------------------
                    */

                    if (
                        request.status ===
                        "completed"
                    ) {

                        const feedbackParagraph =
                            document.createElement(
                                "p"
                            );

                        const feedbackLink =
                            document.createElement(
                                "a"
                            );

                        feedbackLink.href =
                            "index.php?page=helpseeker-feedback&id=" +
                            encodeURIComponent(
                                request.id
                            );

                        feedbackLink.textContent =
                            "Give Feedback";

                        feedbackParagraph.appendChild(
                            feedbackLink
                        );

                        card.appendChild(
                            feedbackParagraph
                        );
                    }


                    requestList.appendChild(
                        card
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE DETAIL LINE
        |--------------------------------------------------------------------------
        */

        function appendDetail(
            card,
            label,
            value
        ) {
            const paragraph =
                document.createElement("p");

            const strong =
                document.createElement(
                    "strong"
                );

            strong.textContent =
                label + " ";

            paragraph.appendChild(
                strong
            );

            paragraph.appendChild(
                document.createTextNode(
                    String(value)
                )
            );

            card.appendChild(
                paragraph
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE STATUS
        |--------------------------------------------------------------------------
        */

        function appendStatus(
            card,
            status
        ) {
            const paragraph =
                document.createElement("p");

            const strong =
                document.createElement(
                    "strong"
                );

            strong.textContent =
                "Status: ";

            paragraph.appendChild(
                strong
            );


            const statusSpan =
                document.createElement(
                    "span"
                );

            statusSpan.textContent =
                capitalizeText(status);


            const allowedStatuses = [
                "pending",
                "assigned",
                "ongoing",
                "completed",
                "cancelled"
            ];


            if (
                allowedStatuses.includes(
                    status
                )
            ) {

                statusSpan.className =
                    "status-" + status;

            } else {

                statusSpan.className =
                    "status-pending";
            }


            paragraph.appendChild(
                statusSpan
            );

            card.appendChild(
                paragraph
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CAPITALIZE TEXT
        |--------------------------------------------------------------------------
        */

        function capitalizeText(value)
        {
            value =
                String(value || "");

            if (value === "") {
                return "";
            }

            return (
                value.charAt(0)
                    .toUpperCase() +
                value.slice(1)
            );
        }

    }
);
/*
|--------------------------------------------------------------------------
| HELP SEEKER FORM VALIDATION
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        /*
        |--------------------------------------------------------------------------
        | EMERGENCY REQUEST VALIDATION
        |--------------------------------------------------------------------------
        */

        const emergencyForm =
            document.getElementById(
                "helpSeekerEmergencyForm"
            );


        if (
            emergencyForm &&
            emergencyForm.dataset.validationBound
                !== "1"
        ) {

            emergencyForm.dataset.validationBound =
                "1";


            const emergencyType =
                document.getElementById(
                    "emergency_type"
                );

            const location =
                document.getElementById(
                    "location"
                );

            const description =
                document.getElementById(
                    "description"
                );

            const priority =
                document.getElementById(
                    "priority"
                );

            const victimType =
                document.getElementById(
                    "victim_type"
                );

            const victimInformation =
                document.getElementById(
                    "victim_information"
                );

            const victimCount =
                document.getElementById(
                    "victim_count"
                );

            const contactInformation =
                document.getElementById(
                    "contact_information"
                );

            const errorBox =
                document.getElementById(
                    "helpSeekerClientError"
                );


            const allowedEmergencyTypes = [
                "accident",
                "fire",
                "flood",
                "medical",
                "other"
            ];


            const allowedPriorities = [
                "low",
                "medium",
                "high",
                "critical"
            ];


            const allowedVictimTypes = [
                "self",
                "other"
            ];


            function showEmergencyError(message)
            {
                if (!errorBox) {
                    return;
                }

                errorBox.textContent =
                    message;

                errorBox.hidden =
                    false;
            }


            function clearEmergencyError()
            {
                if (!errorBox) {
                    return;
                }

                errorBox.textContent =
                    "";

                errorBox.hidden =
                    true;
            }


            function updateVictimInformation()
            {
                if (
                    !victimType ||
                    !victimInformation
                ) {
                    return;
                }


                const isOther =
                    victimType.value ===
                    "other";


                victimInformation.required =
                    isOther;


                if (!isOther) {

                    victimInformation.value =
                        "";
                }
            }


            if (victimType) {

                victimType.addEventListener(
                    "change",
                    updateVictimInformation
                );


                updateVictimInformation();
            }


            emergencyForm.addEventListener(
                "submit",
                function (event) {

                    clearEmergencyError();


                    if (
                        !emergencyType ||
                        !allowedEmergencyTypes.includes(
                            emergencyType.value
                        )
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Please select a valid emergency type."
                        );

                        return;
                    }


                    if (
                        !location ||
                        location.value.trim() === ""
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Location is required."
                        );

                        return;
                    }


                    if (
                        location.value.trim()
                            .length > 255
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Location must not exceed 255 characters."
                        );

                        return;
                    }


                    if (
                        !description ||
                        description.value.trim()
                            === ""
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Description is required."
                        );

                        return;
                    }


                    if (
                        !priority ||
                        !allowedPriorities.includes(
                            priority.value
                        )
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Please select a valid priority."
                        );

                        return;
                    }


                    if (
                        !victimType ||
                        !allowedVictimTypes.includes(
                            victimType.value
                        )
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Please select who needs help."
                        );

                        return;
                    }


                    if (
                        victimType.value ===
                            "other" &&
                        (
                            !victimInformation ||
                            victimInformation.value
                                .trim() === ""
                        )
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Please provide information about the victim."
                        );

                        return;
                    }


                    const victimCountValue =
                        Number(
                            victimCount
                                ? victimCount.value
                                : 0
                        );


                    if (
                        !Number.isInteger(
                            victimCountValue
                        ) ||
                        victimCountValue < 1
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Victim count must be a whole number of at least 1."
                        );

                        return;
                    }


                    if (
                        !contactInformation ||
                        contactInformation.value
                            .trim() === ""
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Contact information is required."
                        );

                        return;
                    }


                    if (
                        contactInformation.value
                            .trim().length > 150
                    ) {

                        event.preventDefault();

                        showEmergencyError(
                            "Contact information must not exceed 150 characters."
                        );

                        return;
                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FEEDBACK VALIDATION
        |--------------------------------------------------------------------------
        */

        const feedbackForm =
            document.getElementById(
                "helpSeekerFeedbackForm"
            );


        if (
            feedbackForm &&
            feedbackForm.dataset.validationBound
                !== "1"
        ) {

            feedbackForm.dataset.validationBound =
                "1";


            const message =
                document.getElementById(
                    "message"
                );


            const feedbackError =
                document.getElementById(
                    "helpSeekerFeedbackError"
                );


            feedbackForm.addEventListener(
                "submit",
                function (event) {

                    const value =
                        message
                            ? message.value.trim()
                            : "";


                    if (feedbackError) {

                        feedbackError.hidden =
                            true;

                        feedbackError.textContent =
                            "";
                    }


                    if (value === "") {

                        event.preventDefault();


                        if (feedbackError) {

                            feedbackError.textContent =
                                "Feedback message is required.";

                            feedbackError.hidden =
                                false;
                        }

                        return;
                    }


                    if (value.length > 1000) {

                        event.preventDefault();


                        if (feedbackError) {

                            feedbackError.textContent =
                                "Feedback message must not exceed 1000 characters.";

                            feedbackError.hidden =
                                false;
                        }
                    }
                }
            );
        }

    }
);