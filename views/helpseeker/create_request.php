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

    <div class="helpseeker-request-page">


        <!-- PAGE HEADER -->

        <div class="helpseeker-request-page-header">

            <div>

                <p class="eyebrow">
                    RESCUE REQUEST
                </p>

                <h1>
                    Request Rescue
                </h1>

                <p class="page-subtitle">
                    Provide the emergency, victim and contact details
                    needed to create a rescue request.
                </p>

            </div>


            <div class="helpseeker-request-header-actions">

                <a
                    href="index.php?page=helpseeker-requests"
                    class="secondary-action"
                >
                    My Requests
                </a>

                <a
                    href="index.php?page=helpseeker-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <!-- SERVER ERROR -->

        <?php if (!empty($error)): ?>

            <div class="helpseeker-form-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- CLIENT VALIDATION ERROR -->

        <div
            id="helpSeekerClientError"
            class="helpseeker-form-error"
            hidden
        ></div>


        <!-- FORM CARD -->

        <div class="helpseeker-request-card">


            <!-- CARD HEADER -->

            <div class="helpseeker-request-card-header">

                <div>

                    <p class="helpseeker-card-eyebrow">
                        REQUEST FORM
                    </p>

                    <h2>
                        Rescue Request Information
                    </h2>

                    <p>
                        Fill in the information below.
                        Required fields are marked with an asterisk (*).
                    </p>

                </div>

            </div>


            <form
                id="helpSeekerEmergencyForm"
                method="POST"
                action="index.php?page=helpseeker-request-create"
                novalidate
                class="helpseeker-request-form"
            >

                <?php echo csrfField(); ?>


                <!-- =================================================
                     01 - EMERGENCY DETAILS
                     ================================================= -->

                <section class="helpseeker-request-section">


                    <div class="helpseeker-request-section-heading">

                        <span class="helpseeker-section-number">
                            01
                        </span>


                        <div>

                            <h3>
                                Emergency Details
                            </h3>

                            <p>
                                Describe the emergency and where
                                assistance is required.
                            </p>

                        </div>

                    </div>


                    <div class="helpseeker-request-grid">


                        <!-- EMERGENCY TYPE -->

                        <div class="helpseeker-request-field">

                            <label for="emergency_type">

                                Emergency Type

                                <span>*</span>

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


                        <!-- PRIORITY -->

                        <div class="helpseeker-request-field">

                            <label for="priority">

                                Priority

                                <span>*</span>

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


                        <!-- LOCATION -->

                        <div class="helpseeker-request-field helpseeker-request-field-full">

                            <label for="location">

                                Location

                                <span>*</span>

                            </label>


                            <input
                                type="text"
                                id="location"
                                name="location"
                                maxlength="255"
                                placeholder="Enter the rescue location"
                                value="<?= htmlspecialchars(
                                    $location,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                required
                            >

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="helpseeker-request-field helpseeker-request-field-full">

                            <label for="description">

                                Description

                                <span>*</span>

                            </label>


                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Describe the situation and the assistance needed"
                                required
                            ><?= htmlspecialchars(
                                $description,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?></textarea>

                        </div>

                    </div>

                </section>


                <!-- =================================================
                     02 - VICTIM DETAILS
                     ================================================= -->

                <section class="helpseeker-request-section">


                    <div class="helpseeker-request-section-heading">

                        <span class="helpseeker-section-number">
                            02
                        </span>


                        <div>

                            <h3>
                                Victim Details
                            </h3>

                            <p>
                                Provide information about the person or
                                people who need assistance.
                            </p>

                        </div>

                    </div>


                    <div class="helpseeker-request-grid">


                        <!-- VICTIM TYPE -->

                        <div class="helpseeker-request-field">

                            <label for="victim_type">

                                Who Needs Help?

                                <span>*</span>

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


                        <!-- VICTIM COUNT -->

                        <div class="helpseeker-request-field">

                            <label for="victim_count">

                                Number of Victims

                                <span>*</span>

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


                        <!-- VICTIM INFORMATION -->

                        <div class="helpseeker-request-field helpseeker-request-field-full">

                            <label for="victim_information">
                                Victim Information
                            </label>


                            <textarea
                                id="victim_information"
                                name="victim_information"
                                rows="3"
                                placeholder="Required when requesting help for another person"
                            ><?= htmlspecialchars(
                                $victimInformation,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?></textarea>

                        </div>

                    </div>

                </section>


                <!-- =================================================
                     03 - CONTACT DETAILS
                     ================================================= -->

                <section class="helpseeker-request-section helpseeker-request-section-last">


                    <div class="helpseeker-request-section-heading">

                        <span class="helpseeker-section-number">
                            03
                        </span>


                        <div>

                            <h3>
                                Contact Details
                            </h3>

                            <p>
                                Provide contact information that can be
                                used for this rescue request.
                            </p>

                        </div>

                    </div>


                    <div class="helpseeker-request-grid">


                        <div class="helpseeker-request-field helpseeker-request-field-full">

                            <label for="contact_information">

                                Contact Information

                                <span>*</span>

                            </label>


                            <input
                                type="text"
                                id="contact_information"
                                name="contact_information"
                                maxlength="150"
                                placeholder="Enter contact information"
                                value="<?= htmlspecialchars(
                                    $contactInformation,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                required
                            >

                        </div>

                    </div>

                </section>


                <!-- FORM ACTIONS -->

                <div class="helpseeker-request-form-actions">

                    <a
                        href="index.php?page=helpseeker-requests"
                        class="secondary-action"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="helpseeker-submit-request"
                    >
                        Submit Rescue Request
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script src="assets/js/helpseeker.js"></script>


<?php
require_once "views/partials/footer.php";
?>