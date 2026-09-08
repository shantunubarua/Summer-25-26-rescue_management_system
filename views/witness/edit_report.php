<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>


<div class="content">

    <h1>Edit Incident Report</h1>


    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=witness-report-edit&id=<?php echo (int)$report['id']; ?>"
    >


        <!-- Incident Title -->

        <div>

            <label for="title">
                Incident Title *
            </label>

            <br>

            <input
                type="text"
                id="title"
                name="title"
                maxlength="150"
                value="<?php echo htmlspecialchars($report['title'] ?? ''); ?>"
                required
            >

        </div>

        <br>


        <!-- Description -->

        <div>

            <label for="description">
                Description *
            </label>

            <br>

            <textarea
                id="description"
                name="description"
                rows="6"
                required
            ><?php echo htmlspecialchars($report['description'] ?? ''); ?></textarea>

        </div>

        <br>

<!-- Damage Level -->

<div>

    <label for="damage_level">
        Damage Level *
    </label>

    <br>

    <select
        id="damage_level"
        name="damage_level"
        required
    >

        <option value="low"
            <?php
            echo (
                ($report['damage_level'] ?? '') === 'low'
            )
                ? 'selected'
                : '';
            ?>
        >
            Low
        </option>

        <option value="medium"
            <?php
            echo (
                ($report['damage_level'] ?? '') === 'medium'
            )
                ? 'selected'
                : '';
            ?>
        >
            Medium
        </option>

        <option value="high"
            <?php
            echo (
                ($report['damage_level'] ?? '') === 'high'
            )
                ? 'selected'
                : '';
            ?>
        >
            High
        </option>

    </select>

</div>

<br>
        <!-- Incident Type -->

        <div>

            <label for="incident_type">
                Incident Type *
            </label>

            <br>

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
                    <?php echo (($report['incident_type'] ?? '') === 'accident') ? 'selected' : ''; ?>
                >
                    Accident
                </option>

                <option
                    value="fire"
                    <?php echo (($report['incident_type'] ?? '') === 'fire') ? 'selected' : ''; ?>
                >
                    Fire
                </option>

                <option
                    value="flood"
                    <?php echo (($report['incident_type'] ?? '') === 'flood') ? 'selected' : ''; ?>
                >
                    Flood
                </option>

                <option
                    value="medical"
                    <?php echo (($report['incident_type'] ?? '') === 'medical') ? 'selected' : ''; ?>
                >
                    Medical Emergency
                </option>

                <option
                    value="other"
                    <?php echo (($report['incident_type'] ?? '') === 'other') ? 'selected' : ''; ?>
                >
                    Other
                </option>

            </select>

        </div>

        <br>


        <!-- Location -->

        <div>

            <label for="location">
                Location *
            </label>

            <br>

            <input
                type="text"
                id="location"
                name="location"
                maxlength="255"
                value="<?php echo htmlspecialchars($report['location'] ?? ''); ?>"
                required
            >

        </div>

        <br>


        <!-- Incident Date -->

        <div>

            <label for="incident_date">
                Incident Date *
            </label>

            <br>

            <input
                type="date"
                id="incident_date"
                name="incident_date"
                value="<?php echo htmlspecialchars(
                    !empty($report['incident_date'])
                        ? date('Y-m-d', strtotime($report['incident_date']))
                        : ''
                ); ?>"
                required
            >

        </div>

        <br>


        <!-- Buttons -->

        <button type="submit">
            Update Report
        </button>


        <a
            href="index.php?page=witness-reports"
            style="margin-left: 10px;"
        >
            Cancel
        </a>


    </form>

</div>


<?php require_once "views/partials/footer.php"; ?>