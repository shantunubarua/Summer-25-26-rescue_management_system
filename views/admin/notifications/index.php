<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$totalNotifications =
    is_array($notifications)
    ? count($notifications)
    : 0;


$activeNotifications = 0;
$importantNotifications = 0;
$emergencyNotifications = 0;


if (!empty($notifications)) {

    foreach ($notifications as $item) {

        if (
            strtolower(
                $item['status'] ?? ''
            ) === 'active'
        ) {
            $activeNotifications++;
        }


        if (
            strtolower(
                $item['alert_type'] ?? ''
            ) === 'important'
        ) {
            $importantNotifications++;
        }


        if (
            strtolower(
                $item['alert_type'] ?? ''
            ) === 'emergency'
        ) {
            $emergencyNotifications++;
        }
    }
}

?>

<div class="content">

    <div class="admin-notification-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-notification-header">

            <div>

                <p class="eyebrow">
                    COMMUNICATION MANAGEMENT
                </p>

                <h1>
                    Notifications
                </h1>

                <p class="page-subtitle">
                    Create and manage announcements, alerts and
                    emergency notifications for system users.
                </p>

            </div>


            <a
                href="index.php?page=notification-create"
                class="primary-action"
            >
                + Create Notification
            </a>

        </div>


        <!-- =========================================
             AJAX CSRF TOKEN
             ========================================= -->

        <input
            type="hidden"
            id="notificationCsrfToken"
            value="<?php

                echo htmlspecialchars(
                    getCsrfToken(),
                    ENT_QUOTES,
                    'UTF-8'
                );

            ?>"
        >


        <!-- =========================================
             NOTIFICATION SUMMARY
             ========================================= -->

        <div class="admin-notification-stats">


            <!-- TOTAL -->

            <div class="admin-notification-stat">

                <span>
                    Total Notifications
                </span>

                <strong>
                    <?= (int)$totalNotifications; ?>
                </strong>

                <p>
                    All notification records.
                </p>

            </div>


            <!-- ACTIVE -->

            <div class="admin-notification-stat">

                <span>
                    Active
                </span>

                <strong>
                    <?= (int)$activeNotifications; ?>
                </strong>

                <p>
                    Currently visible alerts.
                </p>

            </div>


            <!-- IMPORTANT -->

            <div class="admin-notification-stat">

                <span>
                    Important
                </span>

                <strong>
                    <?= (int)$importantNotifications; ?>
                </strong>

                <p>
                    Important system notices.
                </p>

            </div>


            <!-- EMERGENCY -->

            <div class="admin-notification-stat">

                <span>
                    Emergency
                </span>

                <strong>
                    <?= (int)$emergencyNotifications; ?>
                </strong>

                <p>
                    Emergency-level alerts.
                </p>

            </div>

        </div>


        <!-- =========================================
             SEARCH
             ========================================= -->

        <section class="admin-notification-search-card">

            <div class="admin-notification-search-heading">

                <div>

                    <p>
                        NOTIFICATION DIRECTORY
                    </p>

                    <h2>
                        Search Notifications
                    </h2>

                </div>


                <div
                    id="notificationSearchMessage"
                    class="admin-notification-search-count"
                >

                    <span>
                        Showing
                    </span>

                    <strong id="notificationCount">
                        <?= (int)$totalNotifications; ?>
                    </strong>

                    <span>
                        notification(s)
                    </span>

                </div>

            </div>


            <div class="admin-notification-search-field">

                <label for="notificationSearch">
                    Search
                </label>

                <input
                    type="search"
                    id="notificationSearch"
                    placeholder="Search by title, message, alert type, audience or status..."
                    autocomplete="off"
                >

            </div>

        </section>


        <!-- =========================================
             TABLE HEADER
             ========================================= -->

        <div class="admin-notification-list-heading">

            <div>

                <p>
                    NOTIFICATION RECORDS
                </p>

                <h2>
                    All Notifications
                </h2>

            </div>

        </div>


        <!-- =========================================
             TABLE
             ========================================= -->

        <div class="admin-notification-table-card">

            <div class="admin-notification-table-wrap">

                <table class="admin-notification-table">

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Notification
                            </th>

                            <th>
                                Message
                            </th>

                            <th>
                                Alert Type
                            </th>

                            <th>
                                Audience
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Created By
                            </th>

                            <th>
                                Created At
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody id="notificationTableBody">


                        <?php if (empty($notifications)): ?>

                            <tr>

                                <td
                                    colspan="9"
                                    class="admin-notification-empty-cell"
                                >

                                    <div class="admin-notification-empty">

                                        <strong>
                                            No Notifications Found
                                        </strong>

                                        <p>
                                            There are currently no
                                            notification records.
                                        </p>

                                    </div>

                                </td>

                            </tr>


                        <?php else: ?>


                            <?php foreach ($notifications as $notification): ?>


                                <?php

                                $alertType =
                                    strtolower(
                                        $notification['alert_type']
                                        ?? 'normal'
                                    );


                                $status =
                                    strtolower(
                                        $notification['status']
                                        ?? 'inactive'
                                    );

                                ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <span class="admin-notification-id">

                                            #<?= (int)$notification['id']; ?>

                                        </span>

                                    </td>


                                    <!-- TITLE -->

                                    <td>

                                        <strong class="admin-notification-title">

                                            <?= htmlspecialchars(
                                                $notification['title']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </strong>

                                    </td>


                                    <!-- MESSAGE -->

                                    <td>

                                        <div class="admin-notification-message">

                                            <?= htmlspecialchars(
                                                $notification['message']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </div>

                                    </td>


                                    <!-- ALERT TYPE -->

                                    <td>

                                        <span
                                            class="admin-alert-type admin-alert-type-<?= htmlspecialchars(
                                                $alertType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst($alertType),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- TARGET AUDIENCE -->

                                    <td>

                                        <span class="admin-audience-badge">

                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $notification[
                                                            'target_audience'
                                                        ] ?? 'all'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="admin-notification-status admin-notification-status-<?= htmlspecialchars(
                                                $status,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst($status),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- CREATED BY -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $notification['admin_name']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </td>


                                    <!-- CREATED AT -->

                                    <td>

                                        <span class="admin-notification-date">

                                            <?= htmlspecialchars(
                                                $notification['created_at']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- ACTIONS -->

                                    <td>

                                        <div class="admin-notification-actions">


                                            <a
                                                href="index.php?page=notification-edit&id=<?= (int)$notification['id']; ?>"
                                                class="admin-notification-edit"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="index.php?page=notification-delete"
                                                class="admin-notification-delete-form"
                                                onsubmit="return confirm(
                                                    'Are you sure you want to delete this notification?'
                                                );"
                                            >

                                                <?php echo csrfField(); ?>


                                                <input
                                                    type="hidden"
                                                    name="notification_id"
                                                    value="<?= (int)$notification['id']; ?>"
                                                >


                                                <button
                                                    type="submit"
                                                    class="admin-notification-delete"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            <?php endforeach; ?>


                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>