<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="witness-form-page">

        <div class="witness-page-header">

            <div>
                <p class="eyebrow">
                    INCIDENT REPORTING
                </p>

                <h1>
                    Report an Incident
                </h1>

                <p class="page-subtitle">
                    Provide accurate incident details and optional
                    evidence so the rescue team can review the situation.
                </p>
            </div>

            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=witness-reports"
                    class="secondary-action"
                >
                    My Reports
                </a>

                <a
                    href="index.php?page=witness-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <?php if (!empty($error)): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <div
            id="witnessValidationMessage"
            class="witness-validation-message"
            role="alert"
        ></div>


        <div class="witness-form-card">

            <div class="witness-form-card-header">

                <div>
                    <span>
                        INCIDENT INFORMATION
                    </span>

                    <h2>
                        Report Details
                    </h2>

                    <p>
                        Fields marked with * are required.
                    </p>
                </div>

            </div>


            <form
                id="witnessReportForm"
                method="POST"
                action="index.php?page=witness-report-create"
                enctype="multipart/form-data"
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
                            placeholder="Example: Road accident near main intersection"
                            value="<?= htmlspecialchars(
                                $_POST['title'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <small>
                            Use a short and clear title for the incident.
                        </small>

                    </div>


                    <!-- INCIDENT TYPE -->

                    <div class="witness-form-group">

                        <label for="incident_type">
                            Incident Type
                            <span class="required-mark">*</span>
                        </label>

                        <?php
                        $selectedIncidentType =
                            $_POST['incident_type']
                            ?? '';
                        ?>

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
                                <?= $selectedIncidentType === 'accident'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Accident
                            </option>

                            <option
                                value="fire"
                                <?= $selectedIncidentType === 'fire'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Fire
                            </option>

                            <option
                                value="flood"
                                <?= $selectedIncidentType === 'flood'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Flood
                            </option>

                            <option
                                value="medical"
                                <?= $selectedIncidentType === 'medical'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medical Emergency
                            </option>

                            <option
                                value="other"
                                <?= $selectedIncidentType === 'other'
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

                        <?php
                        $selectedDamage =
                            $_POST['damage_level']
                            ?? '';
                        ?>

                        <select
                            id="damage_level"
                            name="damage_level"
                            required
                        >

                            <option value="">
                                Select damage level
                            </option>

                            <option
                                value="low"
                                <?= $selectedDamage === 'low'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Low
                            </option>

                            <option
                                value="medium"
                                <?= $selectedDamage === 'medium'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medium
                            </option>

                            <option
                                value="high"
                                <?= $selectedDamage === 'high'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                High
                            </option>

                            <option
                                value="critical"
                                <?= $selectedDamage === 'critical'
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
                            placeholder="Area, road or landmark"
                            value="<?= htmlspecialchars(
                                $_POST['location'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                    </div>


                    <!-- DATE -->

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
                                $_POST['incident_date'] ?? '',
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
                            placeholder="Describe what happened, visible damage and any important information..."
                        ><?= htmlspecialchars(
                            $_POST['description'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?></textarea>

                    </div>


                    <!-- EVIDENCE -->

                    <div class="witness-form-group witness-form-full">

                        <label for="evidence_file">
                            Evidence File
                        </label>

                        <div class="witness-upload-box">

                            <input
                                type="file"
                                id="evidence_file"
                                name="evidence_file"
                                accept=".jpg,.jpeg,.png,.pdf"
                            >

                            <div class="witness-upload-info">

                                <strong>
                                    Optional supporting evidence
                                </strong>

                                <span>
                                    JPG, JPEG, PNG or PDF • Maximum 5 MB
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="witness-form-actions">

                    <button
                        type="submit"
                        class="primary-action"
                    >
                        Submit Incident Report
                    </button>

                    <a
                        href="index.php?page=witness-reports"
                        class="secondary-action"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="assets/js/witness.js?v=5"></script>

<?php require_once "views/partials/footer.php"; ?>