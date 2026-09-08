<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>


<div class="content">

    <h1>My Incident Reports</h1>


    <p>
        <a href="index.php?page=witness-report-create">
            Report New Incident
        </a>
    </p>


    <?php if (empty($reports)): ?>

        <p>
            You have not submitted any incident reports yet.
        </p>

    <?php else: ?>


        <table border="1" cellpadding="10">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Title</th>

                    <th>Incident Type</th>

                    <!-- DAMAGE LEVEL -->
                    <th>Damage Level</th>

                    <th>Location</th>

                    <th>Incident Date</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                <?php foreach ($reports as $report): ?>

                    <tr>


                        <!-- ID -->

                        <td>

                            <?php

                            echo (int)$report['id'];

                            ?>

                        </td>



                        <!-- TITLE -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                $report['title']

                            );

                            ?>

                        </td>



                        <!-- INCIDENT TYPE -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                ucfirst(

                                    $report['incident_type']

                                )

                            );

                            ?>

                        </td>



                        <!-- DAMAGE LEVEL -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                ucfirst(

                                    $report['damage_level'] ?? 'Not specified'

                                )

                            );

                            ?>

                        </td>



                        <!-- LOCATION -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                $report['location']

                            );

                            ?>

                        </td>



                        <!-- INCIDENT DATE -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                $report['incident_date']

                            );

                            ?>

                        </td>



                        <!-- STATUS -->

                        <td>

                            <?php

                            echo htmlspecialchars(

                                ucfirst(

                                    $report['status'] ?? 'pending'

                                )

                            );

                            ?>

                        </td>



                        <!-- ACTION -->

                        <td>


                            <!-- VIEW -->

                            <a

                                href="index.php?page=witness-report-view&id=<?php echo (int)$report['id']; ?>"

                            >

                                View

                            </a>


                            &nbsp;


                            <!-- EDIT -->

                            <a

                                href="index.php?page=witness-report-edit&id=<?php echo (int)$report['id']; ?>"

                            >

                                Edit

                            </a>


                            &nbsp;


                            <!-- DELETE -->

                            <form

                                method="POST"

                                action="index.php?page=witness-report-delete"

                                style="display:inline;"

                                onsubmit="return confirm('Are you sure you want to delete this report?');"

                            >

                                <input

                                    type="hidden"

                                    name="id"

                                    value="<?php echo (int)$report['id']; ?>"

                                >


                                <button type="submit">

                                    Delete

                                </button>

                            </form>


                        </td>


                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>


    <?php endif; ?>


</div>


<?php require_once "views/partials/footer.php"; ?>