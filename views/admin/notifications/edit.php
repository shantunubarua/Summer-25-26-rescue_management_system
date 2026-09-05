<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Edit Notification</h1>

    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=notification-edit&id=<?php echo (int)$notification['id']; ?>"
    >

        <div>

            <label for="title">
                Title
            </label>

            <br>

            <input
                type="text"
                id="title"
                name="title"
                maxlength="150"
                value="<?php echo htmlspecialchars($notification['title']); ?>"
                required
            >

        </div>

        <br>


        <div>

            <label for="message">
                Message
            </label>

            <br>

            <textarea
                id="message"
                name="message"
                rows="5"
                required
            ><?php echo htmlspecialchars($notification['message']); ?></textarea>

        </div>

        <br>


        <div>

            <label for="alert_type">
                Alert Type
            </label>

            <br>

            <select
                id="alert_type"
                name="alert_type"
            >

                <option
                    value="normal"
                    <?php echo $notification['alert_type'] === 'normal' ? 'selected' : ''; ?>
                >
                    Normal
                </option>

                <option
                    value="important"
                    <?php echo $notification['alert_type'] === 'important' ? 'selected' : ''; ?>
                >
                    Important
                </option>

                <option
                    value="emergency"
                    <?php echo $notification['alert_type'] === 'emergency' ? 'selected' : ''; ?>
                >
                    Emergency
                </option>

            </select>

        </div>

        <br>


        <div>

            <label for="status">
                Status
            </label>

            <br>

            <select
                id="status"
                name="status"
            >

                <option
                    value="active"
                    <?php echo $notification['status'] === 'active' ? 'selected' : ''; ?>
                >
                    Active
                </option>

                <option
                    value="inactive"
                    <?php echo $notification['status'] === 'inactive' ? 'selected' : ''; ?>
                >
                    Inactive
                </option>

            </select>

        </div>

        <br>

        <button type="submit">
            Update Notification
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>