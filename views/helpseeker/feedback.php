<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

?>

<div class="content">

    <h1>Give Feedback</h1>

    <p>
        Share your feedback about the completed rescue activity.
    </p>


    <div class="card">

        <h3>
            Emergency Request #
            <?php echo (int)$request['id']; ?>
        </h3>


        <p>
            <strong>Emergency Type:</strong>

            <?php
            echo htmlspecialchars(
                ucfirst($request['emergency_type'])
            );
            ?>
        </p>


        <p>
            <strong>Location:</strong>

            <?php
            echo htmlspecialchars(
                $request['location']
            );
            ?>
        </p>


        <p>
            <strong>Status:</strong>

            <span class="status-completed">
                Completed
            </span>

        </p>

    </div>


    <?php if (!empty($error)): ?>

        <div class="error">

            <?php
            echo htmlspecialchars($error);
            ?>

        </div>

    <?php endif; ?>


    <div class="card">

        <h3>Your Feedback</h3>


        <form
            method="POST"
            action="index.php?page=helpseeker-feedback&id=<?php echo (int)$request['id']; ?>"
        >

            <input
                type="hidden"
                name="rescue_request_id"
                value="<?php echo (int)$request['id']; ?>"
            >


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
                ></textarea>

            </p>


            <p>

                <button type="submit">
                    Submit Feedback
                </button>

                <a
                    href="index.php?page=helpseeker-requests"
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

button {
    padding: 10px 18px;
    cursor: pointer;
}

</style>


<?php require_once "views/partials/footer.php"; ?>