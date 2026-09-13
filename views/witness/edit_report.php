<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<?php

$currentTitle =
    $_POST['title']
    ?? ($report['title'] ?? '');

$currentDescription =
    $_POST['description']
    ?? ($report['description'] ?? '');

$currentDamage =
    $_POST['damage_level']
    ?? ($report['damage_level'] ?? '');

$currentType =
    $_POST['incident_type']
    ?? ($report['incident_type'] ?? '');

$currentLocation =
    $_POST['location']
    ?? ($report['location'] ?? '');

$currentDate =
    $_POST['incident_date']
    ?? (
        !empty($report['incident_date'])
            ? date(
                'Y-m-d',
                strtotime(
                    $report['incident_date']
                )
            )
            : ''
    );

?>

<div class="content">

    <div class="witness-form-page">


        <!-- PAGE HEADER -->

        <div class="witness-page-header">

            <div>

                <p class="eyebrow">
                    INCIDENT MANAGEMENT
                </p>

                <h1>
                    Edit Incident Report
                </h1>

                <p class="page-subtitle">
                    Update the incident information carefully.
                    Your changes will be reflected in the report
                    after submission.
                </p>

            </div>


            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=witness-report-view&id=<?= (int)$report['id']; ?>"
                    class="secondary-action"
                >
                    View Report
                </a>

                <a
                    href="index.php?page=witness-reports"
                    class="secondary-action"
                >
                    My Reports
                </a>

            </div>

        </div>


        <!-- PHP ERROR -->

        <?php if (!empty($error)): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- JS VALIDATION -->

        <div
            id="witnessValidationMessage"
            class="witness-validation-message"
            role="alert"
        ></div>


        <!-- FORM CARD -->

        <div class="witness-form-card">

            <div class="witness-form-card-header">

                <div>

                    <span>
                        UPDATE REPORT
                    </span>

                    <h2>
                        Incident Details
                    </h2>

                    <p>
                        Fields marked with * are required.
                    </p>

                </div>

            </div>


            <form
                id="witnessReportForm"
                method="POST"
                action="index.php?page=witness-report-edit&id=<?= (int)$report['id']; ?>"
                novalidate
                class="witness-modern-form"
            >

                <?= csrfField(); ?>


                <div class="witness-form-grid">


                    <!-- TITLE -->

                    <div class="witness-form-group witness-form-full">

                        <label for="title">
                            Incident Title
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            maxlength="150"
                            required
                            value="<?= htmlspecialchars(
                                $currentTitle,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <small>
                            Use a short and clear title
                            for the incident.
                        </small>

                    </div>


                    <!-- INCIDENT TYPE -->

                    <div class="witness-form-group">

                        <label for="incident_type">
                            Incident Type
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            id="incident_type"
                            name="incident_type"
                            required
                        >

                            <option value="">
                                Select incident type
                            </option>

                            <option
                                value="accident"
                                <?= $currentType === 'accident'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Accident
                            </option>

                            <option
                                value="fire"
                                <?= $currentType === 'fire'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Fire
                            </option>

                            <option
                                value="flood"
                                <?= $currentType === 'flood'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Flood
                            </option>

                            <option
                                value="medical"
                                <?= $currentType === 'medical'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medical Emergency
                            </option>

                            <option
                                value="other"
                                <?= $currentType === 'other'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Other
                            </option>

                        </select>

                    </div>


                    <!-- DAMAGE LEVEL -->

                    <div class="witness-form-group">

                        <label for="damage_level">
                            Damage Level
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            id="damage_level"
                            name="damage_level"
                            required
                        >

                            <option
                                value="low"
                                <?= $currentDamage === 'low'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Low
                            </option>

                            <option
                                value="medium"
                                <?= $currentDamage === 'medium'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medium
                            </option>

                            <option
                                value="high"
                                <?= $currentDamage === 'high'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                High
                            </option>

                            <option
                                value="critical"
                                <?= $currentDamage === 'critical'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Critical
                            </option>

                        </select>

                    </div>


                    <!-- LOCATION -->

                    <div class="witness-form-group">

                        <label for="location">
                            Location
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="text"
                            id="location"
                            name="location"
                            maxlength="255"
                            required
                            value="<?= htmlspecialchars(
                                $currentLocation,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                    </div>


                    <!-- INCIDENT DATE -->

                    <div class="witness-form-group">

                        <label for="incident_date">
                            Incident Date
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="date"
                            id="incident_date"
                            name="incident_date"
                            required
                            value="<?= htmlspecialchars(
                                $currentDate,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                    </div>


                    <!-- DESCRIPTION -->

                    <div class="witness-form-group witness-form-full">

                        <label for="description">
                            Description
                            <span class="required-mark">*</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            required
                        ><?= htmlspecialchars(
                            $currentDescription,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?></textarea>

                        <small>
                            Update the incident description
                            if additional details are available.
                        </small>

                    </div>

                </div>


                <!-- ACTIONS -->

                <div class="witness-form-actions">

                    <button
                        type="submit"
                        class="primary-action"
                    >
                        Update Report
                    </button>

                    <a
                        href="index.php?page=witness-report-view&id=<?= (int)$report['id']; ?>"
                        class="secondary-action"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="assets/js/witness.js?v=7"></script>

<?php require_once "views/partials/footer.php"; ?>