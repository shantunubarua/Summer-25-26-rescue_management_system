<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Edit Notification</h1>

    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?= htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=notification-edit&id=<?= (int)$notification['id']; ?>"
    >
    <?php echo csrfField(); ?>

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
                value="<?= htmlspecialchars($notification['title']); ?>"
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
            ><?= htmlspecialchars($notification['message']); ?></textarea>

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
                required
            >

                <option
                    value="normal"
                    <?= $notification['alert_type'] === 'normal'
                        ? 'selected'
                        : ''; ?>
                >
                    Normal
                </option>

                <option
                    value="important"
                    <?= $notification['alert_type'] === 'important'
                        ? 'selected'
                        : ''; ?>
                >
                    Important
                </option>

                <option
                    value="emergency"
                    <?= $notification['alert_type'] === 'emergency'
                        ? 'selected'
                        : ''; ?>
                >
                    Emergency
                </option>

            </select>

        </div>


        <br>


        <!-- TARGET AUDIENCE -->

        <div>

            <label for="target_audience">
                Target Audience
            </label>

            <br>

            <select
                id="target_audience"
                name="target_audience"
                required
            >

                <option
                    value="all"
                    <?= ($notification['target_audience'] ?? 'all') === 'all'
                        ? 'selected'
                        : ''; ?>
                >
                    All Users
                </option>

                <option
                    value="volunteer"
                    <?= ($notification['target_audience'] ?? 'all') === 'volunteer'
                        ? 'selected'
                        : ''; ?>
                >
                    Volunteers
                </option>

                <option
                    value="witness"
                    <?= ($notification['target_audience'] ?? 'all') === 'witness'
                        ? 'selected'
                        : ''; ?>
                >
                    Witnesses
                </option>

                <option
                    value="help_seeker"
                    <?= ($notification['target_audience'] ?? 'all') === 'help_seeker'
                        ? 'selected'
                        : ''; ?>
                >
                    Help Seekers
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
                required
            >

                <option
                    value="active"
                    <?= $notification['status'] === 'active'
                        ? 'selected'
                        : ''; ?>
                >
                    Active
                </option>

                <option
                    value="inactive"
                    <?= $notification['status'] === 'inactive'
                        ? 'selected'
                        : ''; ?>
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