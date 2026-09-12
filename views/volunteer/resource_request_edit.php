<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

?>

<div class="content">

    <h1>
        Edit Resource Request
    </h1>

    <p>
        Only pending resource requests can be edited.
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
            action="index.php?page=volunteer-resource-request-edit&id=<?= (int)$request['id']; ?>"
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
                            ?? $request['resource_type']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>"
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
                            ?? $request['quantity']
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
                ><?= htmlspecialchars(
                    $_POST['description']
                    ?? $request['description']
                    ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?></textarea>

            </div>


            <button type="submit">
                Update Resource Request
            </button>

            <a href="index.php?page=volunteer-resource-requests">
                Cancel
            </a>

        </form>

    </div>

</div>


<script src="assets/js/volunteer.js"></script>

<?php

require_once
    "views/partials/footer.php";

?>