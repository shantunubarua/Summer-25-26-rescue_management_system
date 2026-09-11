<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$emergencyType =
    $_POST['emergency_type']
    ?? '';

$location =
    $_POST['location']
    ?? '';

$description =
    $_POST['description']
    ?? '';

$priority =
    $_POST['priority']
    ?? 'medium';

$victimType =
    $_POST['victim_type']
    ?? 'self';

$victimInformation =
    $_POST['victim_information']
    ?? '';

$victimCount =
    $_POST['victim_count']
    ?? 1;

$contactInformation =
    $_POST['contact_information']
    ?? '';

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Create Emergency Request
            </h1>

            <p>
                Submit the information below to request rescue assistance.
            </p>

        </div>

    </div>


    <?php if (!empty($error)): ?>

        <div class="error">

            <?php
            echo htmlspecialchars(
                $error
            );
            ?>

        </div>

    <?php endif; ?>


    <div
        id="helpSeekerClientError"
        class="error"
        hidden
    ></div>


    <div class="card">

        <form
            id="helpSeekerEmergencyForm"
            method="POST"
            action="index.php?page=helpseeker-request-create"
            novalidate
        >

            <?php echo csrfField(); ?>


            <div class="form-group">

                <label for="emergency_type">
                    Emergency Type
                </label>

                <select
                    id="emergency_type"
                    name="emergency_type"
                    required
                >

                    <option value="">
                        Select Emergency Type
                    </option>

                    <option
                        value="accident"
                        <?= $emergencyType === 'accident'
                            ? 'selected'
                            : ''; ?>
                    >
                        Accident
                    </option>

                    <option
                        value="fire"
                        <?= $emergencyType === 'fire'
                            ? 'selected'
                            : ''; ?>
                    >
                        Fire
                    </option>

                    <option
                        value="flood"
                        <?= $emergencyType === 'flood'
                            ? 'selected'
                            : ''; ?>
                    >
                        Flood
                    </option>

                    <option
                        value="medical"
                        <?= $emergencyType === 'medical'
                            ? 'selected'
                            : ''; ?>
                    >
                        Medical Emergency
                    </option>

                    <option
                        value="other"
                        <?= $emergencyType === 'other'
                            ? 'selected'
                            : ''; ?>
                    >
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="location">
                    Location
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    maxlength="255"
                    value="<?= htmlspecialchars(
                        $location
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                ><?= htmlspecialchars(
                    $description
                ); ?></textarea>

            </div>


            <div class="form-group">

                <label for="priority">
                    Priority
                </label>

                <select
                    id="priority"
                    name="priority"
                    required
                >

                    <option
                        value="low"
                        <?= $priority === 'low'
                            ? 'selected'
                            : ''; ?>
                    >
                        Low
                    </option>

                    <option
                        value="medium"
                        <?= $priority === 'medium'
                            ? 'selected'
                            : ''; ?>
                    >
                        Medium
                    </option>

                    <option
                        value="high"
                        <?= $priority === 'high'
                            ? 'selected'
                            : ''; ?>
                    >
                        High
                    </option>

                    <option
                        value="critical"
                        <?= $priority === 'critical'
                            ? 'selected'
                            : ''; ?>
                    >
                        Critical
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="victim_type">
                    Who Needs Help?
                </label>

                <select
                    id="victim_type"
                    name="victim_type"
                    required
                >

                    <option
                        value="self"
                        <?= $victimType === 'self'
                            ? 'selected'
                            : ''; ?>
                    >
                        I am the victim
                    </option>

                    <option
                        value="other"
                        <?= $victimType === 'other'
                            ? 'selected'
                            : ''; ?>
                    >
                        Another person is the victim
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="victim_information">
                    Victim Information
                </label>

                <textarea
                    id="victim_information"
                    name="victim_information"
                    rows="3"
                    placeholder="Required when requesting help for another person"
                ><?= htmlspecialchars(
                    $victimInformation
                ); ?></textarea>

            </div>


            <div class="form-group">

                <label for="victim_count">
                    Number of Victims
                </label>

                <input
                    type="number"
                    id="victim_count"
                    name="victim_count"
                    min="1"
                    value="<?= (int)$victimCount; ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="contact_information">
                    Contact Information
                </label>

                <input
                    type="text"
                    id="contact_information"
                    name="contact_information"
                    maxlength="150"
                    value="<?= htmlspecialchars(
                        $contactInformation
                    ); ?>"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Submit Emergency Request
            </button>

        </form>

    </div>

</div>


<style>

.error {
    color: #721c24;
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    padding: 10px;
    margin: 15px 0;
    border-radius: 5px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    max-width: 700px;
    padding: 10px;
    box-sizing: border-box;
}

</style>


<script src="assets/js/helpseeker.js"></script>

<?php
require_once "views/partials/footer.php";
?>