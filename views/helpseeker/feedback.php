<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$message =
    $_POST['message']
    ?? '';

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Give Feedback
            </h1>

            <p>
                Share your feedback about the completed rescue activity.
            </p>

        </div>

    </div>


    <div class="card">

        <h3>
            Emergency Request #
            <?= (int)$request['id']; ?>
        </h3>


        <p>
            <strong>
                Emergency Type:
            </strong>

            <?= htmlspecialchars(
                ucfirst(
                    $request['emergency_type']
                    ?? 'N/A'
                )
            ); ?>
        </p>


        <p>
            <strong>
                Location:
            </strong>

            <?= htmlspecialchars(
                $request['location']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>
                Status:
            </strong>

            <span class="status-completed">
                Completed
            </span>
        </p>

    </div>


    <?php if (!empty($error)): ?>

        <div class="error">

            <?= htmlspecialchars(
                $error
            ); ?>

        </div>

    <?php endif; ?>


    <div
        id="helpSeekerFeedbackError"
        class="error"
        hidden
    ></div>


    <div class="card">

        <h3>
            Your Feedback
        </h3>


        <form
            id="helpSeekerFeedbackForm"
            method="POST"
            action="index.php?page=helpseeker-feedback&id=<?= (int)$request['id']; ?>"
            novalidate
        >

            <?php echo csrfField(); ?>


            <p>

                <label for="message">
                    Feedback Message
                </label>

            </p>


            <p>

                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    maxlength="1000"
                    placeholder="Write your feedback here..."
                    required
                ><?= htmlspecialchars(
                    $message
                ); ?></textarea>

            </p>


            <p>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Submit Feedback
                </button>

                <a
                    href="index.php?page=helpseeker-requests"
                    class="btn"
                >
                    Cancel
                </a>

            </p>

        </form>

    </div>

</div>


<style>

.status-completed {
    color: #155724;
    background-color: #c3e6cb;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.error {
    color: #721c24;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    padding: 10px;
    margin: 15px 0;
    border-radius: 5px;
}

textarea {
    width: 100%;
    max-width: 600px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    box-sizing: border-box;
}

</style>


<script src="assets/js/helpseeker.js"></script>

<?php
require_once "views/partials/footer.php";
?>