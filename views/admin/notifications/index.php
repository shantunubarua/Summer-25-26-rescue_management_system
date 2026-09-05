<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Notifications</h1>

    <div class="notification-search">

    <label for="notificationSearch">
        Search Notifications
    </label>

    <br>

    <input
        type="text"
        id="notificationSearch"
        placeholder="Search by title, message, type or status..."
    >

</div>

<br>

<p
    id="noSearchResult"
    style="display: none;"
>
    No matching notification found.
</p>

    <p>
        <a href="index.php?page=notification-create">
            Create New Notification
        </a>
    </p>

    <?php if (empty($notifications)): ?>

        <p>No notifications found.</p>

    <?php else: ?>

        <table border="1" cellpadding="10">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Alert Type</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($notifications as $notification): ?>

                    <tr class="notification-row">

                        <td>
                            <?php echo (int)$notification['id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['title']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['message']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['alert_type']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['status']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['admin_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($notification['created_at']); ?>
                        </td>

                        <td>

    <a href="index.php?page=notification-edit&id=<?php echo (int)$notification['id']; ?>">
        Edit
    </a>

    |

    <a
        href="index.php?page=notification-delete&id=<?php echo (int)$notification['id']; ?>"
        onclick="return confirm('Are you sure you want to delete this notification?');"
    >
        Delete
    </a>

</td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>