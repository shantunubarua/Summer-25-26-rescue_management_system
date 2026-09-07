<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Create Notification</h1>

    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?= htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=notification-create"
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
                value="<?= htmlspecialchars($_POST['title'] ?? ''); ?>"
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
            ><?= htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

        </div>


        <br>


        <div>

            <label for="alert_type">
                Alert Type
            </label>

            <br>

            <?php
            $selectedAlertType =
                $_POST['alert_type'] ?? 'normal';
            ?>

            <select
                id="alert_type"
                name="alert_type"
                required
            >

                <option
                    value="normal"
                    <?= $selectedAlertType === 'normal'
                        ? 'selected'
                        : ''; ?>
                >
                    Normal
                </option>

                <option
                    value="important"
                    <?= $selectedAlertType === 'important'
                        ? 'selected'
                        : ''; ?>
                >
                    Important
                </option>

                <option
                    value="emergency"
                    <?= $selectedAlertType === 'emergency'
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

            <?php
            $selectedAudience =
                $_POST['target_audience']
                ?? 'all';
            ?>

            <select
                id="target_audience"
                name="target_audience"
                required
            >

                <option
                    value="all"
                    <?= $selectedAudience === 'all'
                        ? 'selected'
                        : ''; ?>
                >
                    All Users
                </option>

                <option
                    value="volunteer"
                    <?= $selectedAudience === 'volunteer'
                        ? 'selected'
                        : ''; ?>
                >
                    Volunteers
                </option>

                <option
                    value="witness"
                    <?= $selectedAudience === 'witness'
                        ? 'selected'
                        : ''; ?>
                >
                    Witnesses
                </option>

                <option
                    value="help_seeker"
                    <?= $selectedAudience === 'help_seeker'
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

            <?php
            $selectedStatus =
                $_POST['status'] ?? 'active';
            ?>

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="active"
                    <?= $selectedStatus === 'active'
                        ? 'selected'
                        : ''; ?>
                >
                    Active
                </option>

                <option
                    value="inactive"
                    <?= $selectedStatus === 'inactive'
                        ? 'selected'
                        : ''; ?>
                >
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