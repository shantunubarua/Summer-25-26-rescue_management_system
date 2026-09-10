<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>


<div class="content">

    <h1>Create Notification</h1>


    <?php if (!empty($error)): ?>

        <p style="color: red;">

            <?php
            echo htmlspecialchars(
                $error
            );
            ?>

        </p>

    <?php endif; ?>


    <form
    method="POST"
    action="index.php?page=notification-create"
    id="notificationCreateForm"
    novalidate
>
        <?php echo csrfField(); ?>

        <!-- TITLE -->

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
                value="<?php
                    echo htmlspecialchars(
                        $_POST['title'] ?? ''
                    );
                ?>"
                required
            >

        </div>


        <br>


        <!-- MESSAGE -->

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
            ><?php
                echo htmlspecialchars(
                    $_POST['message'] ?? ''
                );
            ?></textarea>

        </div>


        <br>


        <!-- ALERT TYPE -->

        <div>

            <label for="alert_type">
                Alert Type
            </label>

            <br>


            <?php

            $selectedAlertType =
                $_POST['alert_type']
                ?? 'normal';

            ?>


            <select
                id="alert_type"
                name="alert_type"
                required
            >

                <option
                    value="normal"
                    <?php
                    echo $selectedAlertType === 'normal'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Normal
                </option>


                <option
                    value="important"
                    <?php
                    echo $selectedAlertType === 'important'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Important
                </option>


                <option
                    value="emergency"
                    <?php
                    echo $selectedAlertType === 'emergency'
                        ? 'selected'
                        : '';
                    ?>
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
                    <?php
                    echo $selectedAudience === 'all'
                        ? 'selected'
                        : '';
                    ?>
                >
                    All Users
                </option>


                <option
                    value="volunteer"
                    <?php
                    echo $selectedAudience === 'volunteer'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Volunteers
                </option>


                <option
                    value="witness"
                    <?php
                    echo $selectedAudience === 'witness'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Witnesses
                </option>


                <option
                    value="help_seeker"
                    <?php
                    echo $selectedAudience === 'help_seeker'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Help Seekers
                </option>

            </select>

        </div>


        <br>


        <!-- STATUS -->

        <div>

            <label for="status">
                Status
            </label>

            <br>


            <?php

            $selectedStatus =
                $_POST['status']
                ?? 'active';

            ?>


            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="active"
                    <?php
                    echo $selectedStatus === 'active'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Active
                </option>


                <option
                    value="inactive"
                    <?php
                    echo $selectedStatus === 'inactive'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Inactive
                </option>

            </select>

        </div>


        <br>


        <!-- JAVASCRIPT VALIDATION MESSAGE -->

        <p
            id="notificationValidationMessage"
            style="display: none;"
        ></p>


        <!-- SUBMIT -->

        <button type="submit">
            Create Notification
        </button>


    </form>

</div>


<?php require_once "views/partials/footer.php"; ?>