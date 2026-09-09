<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>


<div class="content">

    <h1>My Incident Reports</h1>


    <!-- CREATE REPORT -->
    <p>
        <a href="index.php?page=witness-report-create">
            Report New Incident
        </a>
    </p>


    <!--
    |--------------------------------------------------------------------------
    | AJAX SEARCH
    |--------------------------------------------------------------------------
    -->

    <div class="witness-report-search">

        <label for="witnessReportSearch">
            Search Incident Reports
        </label>

        <br>

        <input
            type="text"
            id="witnessReportSearch"
            placeholder="Search by title, type, location, damage level or status..."
            autocomplete="off"
        >

        <p id="witnessSearchStatus">

            <?php
            $initialCount = is_array($reports)
                ? count($reports)
                : 0;
            ?>

            Showing
            <strong id="witnessSearchCount">
                <?php echo $initialCount; ?>
            </strong>
            report(s).

        </p>

    </div>


    <!--
    |--------------------------------------------------------------------------
    | REPORT TABLE
    |--------------------------------------------------------------------------
    -->

    <table
        border="1"
        cellpadding="10"
        id="witnessReportTable"
    >

        <thead>

            <tr>

                <th>ID</th>

                <th>Title</th>

                <th>Incident Type</th>

                <th>Damage Level</th>

                <th>Location</th>

                <th>Incident Date</th>

                <th>Status</th>

                <th>Action</th>

            </tr>

        </thead>


        <tbody id="witnessReportTableBody">

            <?php if (empty($reports)): ?>

                <tr id="witnessNoReportsRow">

                    <td colspan="8">

                        You have not submitted any incident reports yet.

                    </td>

                </tr>

            <?php else: ?>


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
                                $report['title'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <!-- INCIDENT TYPE -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $report['incident_type'] ?? ''
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <!-- DAMAGE LEVEL -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $report['damage_level']
                                    ?? 'Not specified'
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <!-- LOCATION -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $report['location'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <!-- INCIDENT DATE -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $report['incident_date'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <!-- STATUS -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $report['status']
                                    ?? 'pending'
                                ),
                                ENT_QUOTES,
                                'UTF-8'
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
                                class="witness-delete-form"
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


            <?php endif; ?>

        </tbody>

    </table>


    <!-- AJAX ERROR / INFORMATION -->

    <p
        id="witnessSearchMessage"
        aria-live="polite"
    ></p>


</div>


<?php require_once "views/partials/footer.php"; ?>