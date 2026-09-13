<?php

$role =
    $_SESSION['user']['role']
    ?? '';

$currentPage =
    $_GET['page']
    ?? '';

$userName =
    $_SESSION['user']['name']
    ?? 'User';


$isActive =
    function ($pages) use ($currentPage) {

        if (!is_array($pages)) {
            $pages = [$pages];
        }

        return in_array(
            $currentPage,
            $pages,
            true
        )
            ? 'active'
            : '';
    };

?>

<aside class="sidebar">

    <div class="sidebar-brand">

        <div class="sidebar-logo">
            RMS
        </div>

        <div>

            <strong>
                Rescue Management
            </strong>

            <span>
                System
            </span>

        </div>

    </div>


    <div class="sidebar-user">

        <span class="sidebar-user-label">
            Signed in as
        </span>

        <strong>
            <?=
                htmlspecialchars(
                    $userName,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>
        </strong>

    </div>


    <?php if ($role === 'admin'): ?>

        <div class="sidebar-section-title">
            Admin Panel
        </div>

        <nav class="sidebar-nav">

            <a
                class="<?= $isActive('admin-dashboard'); ?>"
                href="index.php?page=admin-dashboard"
            >
                Dashboard
            </a>

            <a
                class="<?= $isActive(['notifications', 'notification-create', 'notification-edit']); ?>"
                href="index.php?page=notifications"
            >
                Notifications
            </a>

            <a
                class="<?= $isActive('feedback'); ?>"
                href="index.php?page=feedback"
            >
                Feedback
            </a>

            <a
                class="<?= $isActive(['admin-witness-reports', 'admin-witness-report-view']); ?>"
                href="index.php?page=admin-witness-reports"
            >
                Witness Reports
            </a>

            <a
                class="<?= $isActive(['rescue-reports', 'rescue-report-view', 'rescue-report-create', 'rescue-report-edit']); ?>"
                href="index.php?page=rescue-reports"
            >
                Rescue Reports
            </a>

            <a
                class="<?= $isActive(['admin-resource-requests', 'admin-resource-request-view']); ?>"
                href="index.php?page=admin-resource-requests"
            >
                Resource Requests
            </a>

            <a
                class="<?= $isActive(['admin-donations', 'admin-donation-view']); ?>"
                href="index.php?page=admin-donations"
            >
                Donations
            </a>

            <a
                class="<?= $isActive('change-password'); ?>"
                href="index.php?page=change-password"
            >
                Change Password
            </a>

        </nav>


    <?php elseif ($role === 'witness'): ?>

        <div class="sidebar-section-title">
            Witness Panel
        </div>

        <nav class="sidebar-nav">

            <a
                class="<?= $isActive('witness-dashboard'); ?>"
                href="index.php?page=witness-dashboard"
            >
                Dashboard
            </a>

            <a
                class="<?= $isActive('witness-report-create'); ?>"
                href="index.php?page=witness-report-create"
            >
                Report Incident
            </a>

            <a
                class="<?= $isActive(['witness-reports', 'witness-report-view', 'witness-report-edit']); ?>"
                href="index.php?page=witness-reports"
            >
                My Reports
            </a>

            <a
                class="<?= $isActive(['donation-create', 'donation-payment']); ?>"
                href="index.php?page=donation-create"
            >
                Make Donation
            </a>

            <a
                class="<?= $isActive('donations'); ?>"
                href="index.php?page=donations"
            >
                My Donations
            </a>

            <a
                class="<?= $isActive('change-password'); ?>"
                href="index.php?page=change-password"
            >
                Change Password
            </a>

        </nav>


    <?php elseif ($role === 'volunteer'): ?>

        <div class="sidebar-section-title">
            Volunteer Panel
        </div>

        <nav class="sidebar-nav">

            <a
                class="<?= $isActive('volunteer-dashboard'); ?>"
                href="index.php?page=volunteer-dashboard"
            >
                Dashboard
            </a>

            <a
                class="<?= $isActive('volunteer-emergency-requests'); ?>"
                href="index.php?page=volunteer-emergency-requests"
            >
                Emergency Requests
            </a>

            <a
                class="<?= $isActive('volunteer-activities'); ?>"
                href="index.php?page=volunteer-activities"
            >
                My Rescue Activities
            </a>

         
            <a
                class="<?= $isActive('volunteer-availability'); ?>"
                href="index.php?page=volunteer-availability"
            >
                My Availability
            </a>
            <a
                class="<?= $isActive('volunteer-profile'); ?>"
                href="index.php?page=volunteer-profile"
            >
                My Profile
            </a>


            <a
                class="<?= $isActive('volunteer-resource-request'); ?>"
                href="index.php?page=volunteer-resource-request"
            >
                Resource Request
            </a>

            <a
                class="<?= $isActive(['volunteer-resource-requests', 'volunteer-resource-request-edit']); ?>"
                href="index.php?page=volunteer-resource-requests"
            >
                My Resource Requests
            </a>

            <a
                class="<?= $isActive('change-password'); ?>"
                href="index.php?page=change-password"
            >
                Change Password
            </a>

        </nav>


    <?php elseif ($role === 'help_seeker'): ?>

        <div class="sidebar-section-title">
            Help Seeker Panel
        </div>

        <nav class="sidebar-nav">

            <a
                class="<?= $isActive('helpseeker-dashboard'); ?>"
                href="index.php?page=helpseeker-dashboard"
            >
                Dashboard
            </a>

            <a
                class="<?= $isActive('helpseeker-request-create'); ?>"
                href="index.php?page=helpseeker-request-create"
            >
                Request Rescue
            </a>

            <a
                class="<?= $isActive(['helpseeker-requests', 'helpseeker-request-view', 'helpseeker-request-edit']); ?>"
                href="index.php?page=helpseeker-requests"
            >
                My Requests
            </a>

            <a
                class="<?= $isActive('helpseeker-nearby-volunteers'); ?>"
                href="index.php?page=helpseeker-nearby-volunteers"
            >
                Nearby Volunteers
            </a>

            <a
                class="<?= $isActive('helpseeker-profile'); ?>"
                href="index.php?page=helpseeker-profile"
            >
                My Profile
            </a>

            <a
                class="<?= $isActive('change-password'); ?>"
                href="index.php?page=change-password"
            >
                Change Password
            </a>

        </nav>

    <?php endif; ?>


    <div class="sidebar-footer">

        <form
            method="POST"
            action="index.php?page=logout"
        >

            <?= csrfField(); ?>

            <button
                type="submit"
                class="sidebar-logout"
            >
                Logout
            </button>

        </form>

    </div>

</aside>