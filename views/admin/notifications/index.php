<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <h1>Notifications</h1>

    <input
    type="hidden"
    id="notificationCsrfToken"
    value="<?php echo htmlspecialchars(
        getCsrfToken(),
        ENT_QUOTES,
        'UTF-8'
    ); ?>"
>


    <p>
        <a href="index.php?page=notification-create">
            Create New Notification
        </a>
    </p>


    <!--
    |--------------------------------------------------------------------------
    | SEARCH NOTIFICATIONS
    |--------------------------------------------------------------------------
    -->

    <div class="notification-search">

        <label for="notificationSearch">
            <strong>Search Notifications</strong>
        </label>

        <br><br>

        <input
            type="search"
            id="notificationSearch"
            placeholder="Search by title, message, alert type, audience or status..."
            autocomplete="off"
        >

        <p id="notificationSearchMessage">

            Showing

            <strong id="notificationCount">
                <?php echo count($notifications); ?>
            </strong>

            notification(s).

        </p>

    </div>


    <!--
    |--------------------------------------------------------------------------
    | NOTIFICATION TABLE
    |--------------------------------------------------------------------------
    -->

    <table
        border="1"
        cellpadding="10"
    >

        <thead>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Message</th>

                <th>Alert Type</th>

                <th>Target Audience</th>

                <th>Status</th>

                <th>Created By</th>

                <th>Created At</th>

                <th>Actions</th>

            </tr>

        </thead>


        <tbody id="notificationTableBody">

            <?php if (empty($notifications)): ?>

                <tr>

                    <td colspan="9">
                        No notifications found.
                    </td>

                </tr>

            <?php else: ?>


                <?php foreach ($notifications as $notification): ?>

                    <tr>

                        <!-- ID -->

                        <td>
                            <?php
                            echo (int)$notification['id'];
                            ?>
                        </td>


                        <!-- TITLE -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $notification['title']
                            );
                            ?>
                        </td>


                        <!-- MESSAGE -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $notification['message']
                            );
                            ?>
                        </td>


                        <!-- ALERT TYPE -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $notification['alert_type']
                                )
                            );
                            ?>
                        </td>


                        <!-- TARGET AUDIENCE -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $notification[
                                            'target_audience'
                                        ] ?? 'all'
                                    )
                                )
                            );
                            ?>
                        </td>


                        <!-- STATUS -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $notification['status']
                                )
                            );
                            ?>
                        </td>


                        <!-- CREATED BY -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $notification['admin_name']
                            );
                            ?>
                        </td>


                        <!-- CREATED AT -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $notification['created_at']
                            );
                            ?>
                        </td>


                        <!-- ACTIONS -->

<td>

    <a
        href="index.php?page=notification-edit&id=<?php
            echo (int)$notification['id'];
        ?>"
    >
        Edit
    </a>

    |

    <form
        method="POST"
        action="index.php?page=notification-delete"
        style="display: inline;"
        onsubmit="return confirm(
            'Are you sure you want to delete this notification?'
        );"
    >

        <?php echo csrfField(); ?>

        <input
            type="hidden"
            name="notification_id"
            value="<?php
                echo (int)$notification['id'];
            ?>"
        >

        <button type="submit">
            Delete
        </button>

    </form>

</td>

                    </tr>

                <?php endforeach; ?>


            <?php endif; ?>

        </tbody>

    </table>

</div>


<?php
require_once "views/partials/footer.php";
?>