<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

require_once
    "models/VolunteerModel.php";


$requests =
    getVolunteerEmergencyRequests(
        $conn
    );

?>

<div class="content">

    <h1>
        Emergency Requests
    </h1>

    <p>
        View pending emergency requests that need volunteer assistance.
    </p>


    <?php if (empty($requests)): ?>

        <div class="card">

            <h3>
                No Emergency Requests
            </h3>

            <p>
                There are currently no pending emergency requests.
            </p>

        </div>

    <?php else: ?>

        <?php foreach ($requests as $request): ?>

            <div class="card">

                <h3>
                    <?=
                        htmlspecialchars(
                            $request['emergency_type']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </h3>


                <p>
                    <strong>Location:</strong>

                    <?=
                        htmlspecialchars(
                            $request['location']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </p>


                <p>
                    <strong>Description:</strong>

                    <?=
                        htmlspecialchars(
                            $request['description']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </p>


                <p>
                    <strong>Priority:</strong>

                    <?=
                        htmlspecialchars(
                            $request['priority']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </p>


                <p>
                    <strong>Victim Count:</strong>

                    <?= (int)(
                        $request['victim_count']
                        ?? 0
                    ); ?>
                </p>


                <p>
                    <strong>Contact:</strong>

                    <?=
                        htmlspecialchars(
                            $request['contact_information']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </p>


                <p>
                    <strong>Status:</strong>

                    <?=
                        htmlspecialchars(
                            ucfirst(
                                $request['status']
                                ?? ''
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </p>


                <?php
                if (
                    (
                        $request['status']
                        ?? ''
                    ) === 'pending'
                ):
                ?>

                    <form
                        method="POST"
                        action="index.php?page=volunteer-accept-request"
                    >

                        <?= csrfField(); ?>

                        <input
                            type="hidden"
                            name="request_id"
                            value="<?= (int)$request['id']; ?>"
                        >

                        <button type="submit">
                            Accept Request
                        </button>

                    </form>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php

require_once
    "views/partials/footer.php";

?>