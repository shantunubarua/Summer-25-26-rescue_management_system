<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>


<div class="content">

    <h1>Report an Incident</h1>


    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?php
            echo htmlspecialchars($error);
            ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=witness-report-create"
        enctype="multipart/form-data"
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
            ></textarea>

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

        <option value="">
            Select damage level
        </option>

        <option value="low">
            Low
        </option>

        <option value="medium">
            Medium
        </option>

        <option value="high">
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

                <option value="accident">
                    Accident
                </option>

                <option value="fire">
                    Fire
                </option>

                <option value="flood">
                    Flood
                </option>

                <option value="medical">
                    Medical Emergency
                </option>

                <option value="other">
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
                required
            >

        </div>

        <br>


        <!-- Evidence File -->

        <div>

            <label for="evidence_file">
                Evidence File
            </label>

            <br>

            <input
                type="file"
                id="evidence_file"
                name="evidence_file"
                accept=".jpg,.jpeg,.png,.pdf"
            >

            <br>

            <small>
                Allowed: JPG, JPEG, PNG, PDF
                (Maximum 5 MB)
            </small>

        </div>

        <br>


        <!-- Submit -->

        <button type="submit">
            Submit Incident Report
        </button>


    </form>

</div>


<?php require_once "views/partials/footer.php"; ?>