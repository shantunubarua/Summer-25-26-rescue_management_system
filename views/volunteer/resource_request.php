<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";


$isMyRequests =
    (
        $_GET['page']
        ?? ''
    ) === 'volunteer-resource-requests';

?>

<div class="content">
    

<?php if ($isMyRequests): ?>

    <h1>
        My Resource Requests
    </h1>

    <p>
        Search and manage your submitted resource requests.
    </p>

    <p>
        <a href="index.php?page=volunteer-resource-request">
            Request New Resource
        </a>
    </p>


    <div class="card">

        <label for="volunteerResourceSearch">
            Search Resource Requests
        </label>

        <input
            type="text"
            id="volunteerResourceSearch"
            maxlength="100"
            placeholder="Search by resource type, description or status"
            autocomplete="off"
        >

        <p
            id="volunteerResourceSearchMessage"
            aria-live="polite"
        ></p>

    </div>


    <div
        id="volunteerResourceRequestResults"
        data-csrf-token="<?=
            htmlspecialchars(
                getCsrfToken(),
                ENT_QUOTES,
                'UTF-8'
            );
        ?>"
    >

        <?php if (empty($requests)): ?>

            <div class="card">

                <h3>
                    No Resource Requests
                </h3>

                <p>
                    You have not submitted any resource requests yet.
                </p>

            </div>

        <?php else: ?>

            <?php foreach ($requests as $request): ?>

                <div class="card">

                    <h3>
                        <?=
                            htmlspecialchars(
                                $request['resource_type']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>
                    </h3>


                    <p>
                        <strong>
                            Request ID:
                        </strong>

                        <?= (int)(
                            $request['id']
                            ?? 0
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Quantity:
                        </strong>

                        <?= (int)(
                            $request['quantity']
                            ?? 0
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Description:
                        </strong>

                        <?=
                            htmlspecialchars(
                                $request['description']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>
                    </p>


                    <p>
                        <strong>
                            Status:
                        </strong>

                        <?=
                            htmlspecialchars(
                                ucfirst(
                                    $request['status']
                                    ?? 'pending'
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>
                    </p>


                    <p>
                        <strong>
                            Requested At:
                        </strong>

                        <?=
                            htmlspecialchars(
                                $request['created_at']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>
                    </p>


                    <?php
                    if (
                        (
                            $request['status']
                            ?? ''
                        ) === 'pending'
                    ):
                    ?>

                        <p>
                            <a href="index.php?page=volunteer-resource-request-edit&id=<?= (int)$request['id']; ?>">
                                Edit
                            </a>
                        </p>


                        <form
                            method="POST"
                            action="index.php?page=volunteer-resource-request-delete"
                            class="delete-resource-request-form"
                        >

                            <?php csrfField(); ?>

                            <input
                                type="hidden"
                                name="request_id"
                                value="<?= (int)$request['id']; ?>"
                            >

                            <button type="submit">
                                Delete
                            </button>

                        </form>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>


<?php else: ?>

    <h1>
        Request Resource
    </h1>

    <p>
        Submit a request for resources needed during rescue activities.
    </p>


    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?=
                htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>
        </p>

    <?php endif; ?>


    <div class="card">

        <form
            method="POST"
            action="index.php?page=volunteer-resource-request"
            class="volunteer-resource-form"
            novalidate
        >

            <?php csrfField(); ?>


            <p
                class="js-form-error error-message"
                aria-live="polite"
            ></p>


            <div>

                <label for="resource_type">
                    Resource Type *
                </label>

                <input
                    type="text"
                    id="resource_type"
                    name="resource_type"
                    maxlength="100"
                    value="<?=
                        htmlspecialchars(
                            $_POST['resource_type']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>"
                    placeholder="Example: First Aid Kit"
                    required
                >

            </div>


            <div>

                <label for="quantity">
                    Quantity *
                </label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="1"
                    max="100000"
                    step="1"
                    value="<?=
                        htmlspecialchars(
                            $_POST['quantity']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>"
                    required
                >

            </div>


            <div>

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    maxlength="1000"
                    placeholder="Describe the resource you need..."
                ><?= htmlspecialchars(
                    $_POST['description']
                    ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?></textarea>

            </div>


            <button type="submit">
                Submit Resource Request
            </button>

        </form>

    </div>

<?php endif; ?>

</div>


<script src="assets/js/volunteer.js"></script>

<?php

require_once
    "views/partials/footer.php";

?>