<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Nearby Volunteers
            </h1>

            <p>
                Find currently available volunteers by area.
            </p>

        </div>

    </div>


    <div class="card">

        <form
            method="GET"
            action="index.php"
        >

            <input
                type="hidden"
                name="page"
                value="helpseeker-nearby-volunteers"
            >


            <div class="form-group">

                <label for="area">
                    Area / Location
                </label>

                <input
                    type="text"
                    id="area"
                    name="area"
                    maxlength="100"
                    value="<?= htmlspecialchars(
                        $area
                    ); ?>"
                    placeholder="Example: Dhanmondi"
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Search Volunteers
            </button>

        </form>

    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars(
                $error
            ); ?>

        </div>

    <?php endif; ?>


    <div class="card">

        <h2>
            Available Volunteers
        </h2>


        <?php if ($area !== ''): ?>

            <p>
                Showing available volunteers matching:

                <strong>
                    <?= htmlspecialchars(
                        $area
                    ); ?>
                </strong>
            </p>

        <?php else: ?>

            <p>
                Showing all currently available volunteers.
            </p>

        <?php endif; ?>


        <?php if (empty($nearbyVolunteers)): ?>

            <p>
                No available volunteers were found for this area.
            </p>

        <?php else: ?>

            <?php foreach ($nearbyVolunteers as $volunteer): ?>

                <div class="card">

                    <h3>
                        <?= htmlspecialchars(
                            $volunteer['name']
                            ?? 'Volunteer'
                        ); ?>
                    </h3>


                    <p>
                        <strong>
                            Location:
                        </strong>

                        <?= htmlspecialchars(
                            $volunteer['address']
                            ?? 'Not provided'
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Availability:
                        </strong>

                        <?= htmlspecialchars(
                            ucfirst(
                                str_replace(
                                    '_',
                                    ' ',
                                    $volunteer['availability_status']
                                    ?? 'available'
                                )
                            )
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Skills:
                        </strong>

                        <?= htmlspecialchars(
                            $volunteer['skills']
                            ?? 'Not provided'
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Experience:
                        </strong>

                        <?= htmlspecialchars(
                            $volunteer['experience']
                            ?? 'Not provided'
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Blood Group:
                        </strong>

                        <?= htmlspecialchars(
                            $volunteer['blood_group']
                            ?? 'Not provided'
                        ); ?>
                    </p>


                    <p>
                        <strong>
                            Contact:
                        </strong>

                        <?= htmlspecialchars(
                            $volunteer['phone']
                            ?? 'Not provided'
                        ); ?>
                    </p>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

<?php
require_once
    "views/partials/footer.php";
?>