<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Create Notification</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=notification-create">

        <div>
            <label for="title">Title</label>
            <br>
            <input
                type="text"
                id="title"
                name="title"
                maxlength="150"
                required
            >
        </div>

        <br>

        <div>
            <label for="message">Message</label>
            <br>
            <textarea
                id="message"
                name="message"
                rows="5"
                required
            ></textarea>
        </div>

        <br>

        <div>
            <label for="alert_type">Alert Type</label>
            <br>

            <select id="alert_type" name="alert_type">

                <option value="normal">
                    Normal
                </option>

                <option value="important">
                    Important
                </option>

                <option value="emergency">
                    Emergency
                </option>

            </select>
        </div>

        <br>

        <div>
            <label for="status">Status</label>
            <br>

            <select id="status" name="status">

                <option value="active">
                    Active
                </option>

                <option value="inactive">
                    Inactive
                </option>

            </select>
        </div>

        <br>

        <button type="submit">
            Create Notification
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>