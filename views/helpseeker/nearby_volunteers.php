<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$area =
    $area
    ?? '';

$nearbyVolunteers =
    $nearbyVolunteers
    ?? [];

$totalVolunteers =
    is_array($nearbyVolunteers)
    ? count($nearbyVolunteers)
    : 0;

?>

<div class="content">

    <div class="helpseeker-nearby-page">


        <!-- =====================================
             PAGE HEADER
             ===================================== -->

        <div class="helpseeker-nearby-header">

            <div>

                <p class="eyebrow">
                    VOLUNTEER DIRECTORY
                </p>

                <h1>
                    Nearby Volunteers
                </h1>

                <p class="page-subtitle">
                    Search for currently available volunteers
                    using their area or location.
                </p>

            </div>


            <div class="helpseeker-nearby-header-actions">

                <a
                    href="index.php?page=helpseeker-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <!-- =====================================
             ERROR
             ===================================== -->

        <?php if (!empty($error)): ?>

            <div class="helpseeker-nearby-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =====================================
             SEARCH PANEL
             ===================================== -->

        <div class="helpseeker-volunteer-search-card">

            <div class="helpseeker-volunteer-search-heading">

                <div>

                    <span>
                        LOCATION SEARCH
                    </span>

                    <h2>
                        Find Available Volunteers
                    </h2>

                    <p>
                        Enter an area to find volunteers currently
                        available in that location.
                    </p>

                </div>

            </div>


            <form
                method="GET"
                action="index.php"
                class="helpseeker-volunteer-search-form"
            >

                <input
                    type="hidden"
                    name="page"
                    value="helpseeker-nearby-volunteers"
                >


                <div class="helpseeker-volunteer-search-field">

                    <label for="area">
                        Area / Location
                    </label>


                    <div class="helpseeker-volunteer-search-row">

                        <input
                            type="text"
                            id="area"
                            name="area"
                            maxlength="100"
                            value="<?= htmlspecialchars(
                                $area,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                            placeholder="Example: Dhanmondi"
                        >


                        <button
                            type="submit"
                            class="helpseeker-volunteer-search-button"
                        >
                            Search Volunteers
                        </button>

                    </div>

                </div>

            </form>


            <?php if ($area !== ''): ?>

                <div class="helpseeker-search-active">

                    <span>
                        Searching in:
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $area,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>

                    <a
                        href="index.php?page=helpseeker-nearby-volunteers"
                    >
                        Clear Search
                    </a>

                </div>

            <?php endif; ?>

        </div>


        <!-- =====================================
             RESULTS HEADER
             ===================================== -->

        <div class="helpseeker-volunteer-results-header">

            <div>

                <p class="helpseeker-results-eyebrow">
                    SEARCH RESULTS
                </p>

                <h2>
                    Available Volunteers
                </h2>

            </div>


            <div class="helpseeker-volunteer-result-count">

                <strong>
                    <?= (int)$totalVolunteers; ?>
                </strong>

                <span>
                    volunteer<?= $totalVolunteers === 1 ? '' : 's'; ?>
                </span>

            </div>

        </div>


        <!-- =====================================
             VOLUNTEER RESULTS
             ===================================== -->

        <?php if (empty($nearbyVolunteers)): ?>


            <div class="helpseeker-volunteer-empty">

                <div class="helpseeker-volunteer-empty-icon">
                    V
                </div>

                <h3>
                    No Available Volunteers Found
                </h3>


                <?php if ($area !== ''): ?>

                    <p>
                        No currently available volunteers were found
                        for
                        <strong>
                            <?= htmlspecialchars(
                                $area,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>
                        </strong>.
                        Try searching another nearby area.
                    </p>

                    <a
                        href="index.php?page=helpseeker-nearby-volunteers"
                        class="secondary-action"
                    >
                        View All Available Volunteers
                    </a>

                <?php else: ?>

                    <p>
                        There are currently no volunteers marked
                        as available.
                    </p>

                <?php endif; ?>

            </div>


        <?php else: ?>


            <div class="helpseeker-volunteer-grid">


                <?php foreach ($nearbyVolunteers as $volunteer): ?>


                    <?php

                    $volunteerName =
                        $volunteer['name']
                        ?? 'Volunteer';

                    $initial =
                        strtoupper(
                            substr(
                                trim($volunteerName),
                                0,
                                1
                            )
                        );

                    $availability =
                        $volunteer['availability_status']
                        ?? 'available';

                    ?>


                    <article class="helpseeker-volunteer-card">


                        <!-- CARD HEADER -->

                        <div class="helpseeker-volunteer-card-header">


                            <div class="helpseeker-volunteer-avatar">

                                <?= htmlspecialchars(
                                    $initial,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </div>


                            <div class="helpseeker-volunteer-identity">

                                <h3>

                                    <?= htmlspecialchars(
                                        $volunteerName,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </h3>


                                <span class="helpseeker-volunteer-status">

                                    <?= htmlspecialchars(
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $availability
                                            )
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </span>

                            </div>

                        </div>


                        <!-- LOCATION -->

                        <div class="helpseeker-volunteer-location">

                            <span>
                                LOCATION
                            </span>

                            <strong>

                                <?= htmlspecialchars(
                                    $volunteer['address']
                                    ?? 'Not provided',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </strong>

                        </div>


                        <!-- DETAILS -->

                        <div class="helpseeker-volunteer-details">


                            <div class="helpseeker-volunteer-detail">

                                <span>
                                    Skills
                                </span>

                                <p>

                                    <?= htmlspecialchars(
                                        $volunteer['skills']
                                        ?? 'Not provided',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </p>

                            </div>


                            <div class="helpseeker-volunteer-detail">

                                <span>
                                    Experience
                                </span>

                                <p>

                                    <?= htmlspecialchars(
                                        $volunteer['experience']
                                        ?? 'Not provided',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </p>

                            </div>


                            <div class="helpseeker-volunteer-detail">

                                <span>
                                    Blood Group
                                </span>

                                <p>

                                    <?= htmlspecialchars(
                                        $volunteer['blood_group']
                                        ?? 'Not provided',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </p>

                            </div>


                            <div class="helpseeker-volunteer-detail">

                                <span>
                                    Contact
                                </span>

                                <p>

                                    <?= htmlspecialchars(
                                        $volunteer['phone']
                                        ?? 'Not provided',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </p>

                            </div>

                        </div>

                    </article>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>