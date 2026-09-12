document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | RESOURCE REQUEST CREATE / EDIT VALIDATION
        |--------------------------------------------------------------------------
        */

        const resourceForms =
            document.querySelectorAll(
                '.volunteer-resource-form'
            );


        resourceForms.forEach(
            function (form) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        const resourceType =
                            form.querySelector(
                                '[name="resource_type"]'
                            );

                        const quantity =
                            form.querySelector(
                                '[name="quantity"]'
                            );

                        const description =
                            form.querySelector(
                                '[name="description"]'
                            );

                        const errorBox =
                            form.querySelector(
                                '.js-form-error'
                            );


                        if (errorBox) {
                            errorBox.textContent = '';
                        }


                        const typeValue =
                            resourceType
                                ? resourceType.value.trim()
                                : '';


                        const quantityValue =
                            quantity
                                ? quantity.value.trim()
                                : '';


                        const descriptionValue =
                            description
                                ? description.value.trim()
                                : '';


                        let errorMessage = '';


                        if (
                            typeValue.length < 2 ||
                            typeValue.length > 100
                        ) {

                            errorMessage =
                                'Resource type must be between 2 and 100 characters.';

                        } else if (
                            !/^\d+$/.test(
                                quantityValue
                            )
                        ) {

                            errorMessage =
                                'Quantity must be a whole number.';

                        } else {

                            const quantityNumber =
                                Number(
                                    quantityValue
                                );


                            if (
                                !Number.isInteger(
                                    quantityNumber
                                ) ||
                                quantityNumber < 1 ||
                                quantityNumber > 100000
                            ) {

                                errorMessage =
                                    'Quantity must be between 1 and 100000.';

                            } else if (
                                descriptionValue.length > 1000
                            ) {

                                errorMessage =
                                    'Description must not exceed 1000 characters.';
                            }
                        }


                        if (errorMessage !== '') {

                            event.preventDefault();


                            if (errorBox) {

                                errorBox.textContent =
                                    errorMessage;

                            } else {

                                alert(
                                    errorMessage
                                );
                            }
                        }
                    }
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | DELETE CONFIRMATION
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'submit',
            function (event) {

                const form =
                    event.target;


                if (
                    form.classList &&
                    form.classList.contains(
                        'delete-resource-request-form'
                    )
                ) {

                    const confirmed =
                        window.confirm(
                            'Delete this pending resource request?'
                        );


                    if (!confirmed) {

                        event.preventDefault();
                    }
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | VOLUNTEER RESOURCE REQUEST AJAX SEARCH
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.getElementById(
                'volunteerResourceSearch'
            );


        const resultsContainer =
            document.getElementById(
                'volunteerResourceRequestResults'
            );


        const searchMessage =
            document.getElementById(
                'volunteerResourceSearchMessage'
            );


        if (
            !searchInput ||
            !resultsContainer
        ) {
            return;
        }


        let searchTimer = null;


        function addInformationLine(
            card,
            label,
            value
        ) {

            const paragraph =
                document.createElement(
                    'p'
                );


            const strong =
                document.createElement(
                    'strong'
                );


            strong.textContent =
                label + ': ';


            paragraph.appendChild(
                strong
            );


            paragraph.appendChild(
                document.createTextNode(
                    String(
                        value ?? ''
                    )
                )
            );


            card.appendChild(
                paragraph
            );
        }


        function formatStatus(status)
        {
            const value =
                String(
                    status ?? ''
                );


            if (value === '') {
                return '';
            }


            return (
                value.charAt(0).toUpperCase()
                +
                value.slice(1)
            );
        }


        function renderRequests(
            requests
        ) {

            resultsContainer.replaceChildren();


            if (
                !Array.isArray(requests) ||
                requests.length === 0
            ) {

                const card =
                    document.createElement(
                        'div'
                    );


                card.className =
                    'card';


                const heading =
                    document.createElement(
                        'h3'
                    );


                heading.textContent =
                    'No Resource Requests Found';


                card.appendChild(
                    heading
                );


                resultsContainer.appendChild(
                    card
                );


                return;
            }


            const csrfToken =
                resultsContainer.dataset.csrfToken
                || '';


            requests.forEach(
                function (request) {

                    const card =
                        document.createElement(
                            'div'
                        );


                    card.className =
                        'card';


                    const heading =
                        document.createElement(
                            'h3'
                        );


                    heading.textContent =
                        request.resource_type
                        || 'Resource Request';


                    card.appendChild(
                        heading
                    );


                    addInformationLine(
                        card,
                        'Request ID',
                        request.id
                    );


                    addInformationLine(
                        card,
                        'Quantity',
                        request.quantity
                    );


                    addInformationLine(
                        card,
                        'Description',
                        request.description
                    );


                    addInformationLine(
                        card,
                        'Status',
                        formatStatus(
                            request.status
                        )
                    );


                    addInformationLine(
                        card,
                        'Requested At',
                        request.created_at
                    );


                    if (
                        request.status
                        === 'pending'
                    ) {

                        const requestId =
                            Number.parseInt(
                                request.id,
                                10
                            );


                        if (
                            Number.isInteger(
                                requestId
                            ) &&
                            requestId > 0
                        ) {

                            const editParagraph =
                                document.createElement(
                                    'p'
                                );


                            const editLink =
                                document.createElement(
                                    'a'
                                );


                            editLink.textContent =
                                'Edit';


                            editLink.href =
                                'index.php?page=volunteer-resource-request-edit&id='
                                +
                                requestId;


                            editParagraph.appendChild(
                                editLink
                            );


                            card.appendChild(
                                editParagraph
                            );


                            const deleteForm =
                                document.createElement(
                                    'form'
                                );


                            deleteForm.method =
                                'POST';


                            deleteForm.action =
                                'index.php?page=volunteer-resource-request-delete';


                            deleteForm.className =
                                'delete-resource-request-form';


                            const csrfInput =
                                document.createElement(
                                    'input'
                                );


                            csrfInput.type =
                                'hidden';

                            csrfInput.name =
                                'csrf_token';

                            csrfInput.value =
                                csrfToken;


                            deleteForm.appendChild(
                                csrfInput
                            );


                            const idInput =
                                document.createElement(
                                    'input'
                                );


                            idInput.type =
                                'hidden';

                            idInput.name =
                                'request_id';

                            idInput.value =
                                String(
                                    requestId
                                );


                            deleteForm.appendChild(
                                idInput
                            );


                            const deleteButton =
                                document.createElement(
                                    'button'
                                );


                            deleteButton.type =
                                'submit';

                            deleteButton.textContent =
                                'Delete';


                            deleteForm.appendChild(
                                deleteButton
                            );


                            card.appendChild(
                                deleteForm
                            );
                        }
                    }


                    resultsContainer.appendChild(
                        card
                    );
                }
            );
        }


        async function searchRequests()
        {
            const searchValue =
                searchInput.value.trim();


            if (
                searchValue.length > 100
            ) {

                if (searchMessage) {

                    searchMessage.textContent =
                        'Search text must not exceed 100 characters.';
                }


                return;
            }


            if (searchMessage) {

                searchMessage.textContent =
                    'Searching...';
            }


            try {

                const response =
                    await fetch(
                        'index.php?page=volunteer-resource-request-search&search='
                        +
                        encodeURIComponent(
                            searchValue
                        ),
                        {
                            method: 'GET',
                            headers: {
                                'Accept':
                                    'application/json'
                            }
                        }
                    );


                const result =
                    await response.json();


                if (
                    !response.ok ||
                    !result.success
                ) {

                    throw new Error(
                        result.message
                        ||
                        'Unable to search resource requests.'
                    );
                }


                renderRequests(
                    result.data
                );


                if (searchMessage) {

                    searchMessage.textContent =
                        result.count
                        +
                        ' request(s) found.';
                }

            } catch (error) {

                if (searchMessage) {

                    searchMessage.textContent =
                        error.message
                        ||
                        'Unable to search resource requests.';
                }
            }
        }


        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        searchRequests,
                        300
                    );
            }
        );
    }
);