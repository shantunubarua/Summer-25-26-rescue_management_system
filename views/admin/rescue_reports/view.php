<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <!-- SCREEN ONLY ACTIONS -->
    <div class="page-header no-print">

        <div>
            <h1>Rescue Report Details</h1>
            <p>
                View the complete rescue operation report.
            </p>
        </div>

        <div class="report-actions">

            <a
                href="index.php?page=rescue-reports"
                class="btn"
            >
                Back to Reports
            </a>

            <button
                type="button"
                class="btn btn-primary"
                id="printRescueReportBtn"
            >
                Print Report
            </button>

        </div>

    </div>


    <!-- PRINTABLE AREA -->
    <div
        class="printable-rescue-report"
        id="printableRescueReport"
    >

        <!-- REPORT HEADER -->

        <div class="report-document-header">

            <h1>Rescue Management System</h1>

            <h2>Official Rescue Report</h2>

            <p>
                Report ID:
                <strong>
                    #<?= (int)$report['report_id']; ?>
                </strong>
            </p>

            <p>
                Generated:
                <?= htmlspecialchars(
                    date('d M Y, h:i A')
                ); ?>
            </p>

        </div>


        <!-- REPORT SUMMARY -->

        <div class="report-section">

            <h3>Report Summary</h3>

            <div class="report-grid">

                <div class="report-field">
                    <span>Report Status</span>

                    <strong>
                        <?= htmlspecialchars(
                            ucfirst(
                                $report['rescue_status']
                                ?? 'N/A'
                            )
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Emergency Request ID</span>

                    <strong>
                        #<?= (int)$report['emergency_request_id']; ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Report Created</span>

                    <strong>
                        <?php
                        echo !empty($report['report_created_at'])
                            ? htmlspecialchars(
                                date(
                                    'd M Y, h:i A',
                                    strtotime(
                                        $report['report_created_at']
                                    )
                                )
                            )
                            : 'N/A';
                        ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Last Updated</span>

                    <strong>
                        <?php
                        echo !empty($report['report_updated_at'])
                            ? htmlspecialchars(
                                date(
                                    'd M Y, h:i A',
                                    strtotime(
                                        $report['report_updated_at']
                                    )
                                )
                            )
                            : 'N/A';
                        ?>
                    </strong>
                </div>

            </div>

        </div>


        <!-- EMERGENCY INFORMATION -->

        <div class="report-section">

            <h3>Emergency Information</h3>

            <div class="report-grid">

                <div class="report-field">
                    <span>Emergency Type</span>

                    <strong>
                        <?= htmlspecialchars(
                            ucfirst(
                                $report['emergency_type']
                                ?? 'N/A'
                            )
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Priority</span>

                    <strong>
                        <?= htmlspecialchars(
                            ucfirst(
                                $report['priority']
                                ?? 'N/A'
                            )
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Location</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['location']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Emergency Status</span>

                    <strong>
                        <?= htmlspecialchars(
                            ucfirst(
                                $report['emergency_status']
                                ?? 'N/A'
                            )
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Victim Type</span>

                    <strong>
                        <?= htmlspecialchars(
                            ucfirst(
                                $report['victim_type']
                                ?? 'N/A'
                            )
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Victim Count</span>

                    <strong>
                        <?= (int)(
                            $report['victim_count']
                            ?? 0
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Contact Information</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['contact_information']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Request Created</span>

                    <strong>
                        <?php
                        echo !empty($report['request_created_at'])
                            ? htmlspecialchars(
                                date(
                                    'd M Y, h:i A',
                                    strtotime(
                                        $report['request_created_at']
                                    )
                                )
                            )
                            : 'N/A';
                        ?>
                    </strong>
                </div>

            </div>


            <div class="report-description">

                <h4>Emergency Description</h4>

                <p>
                    <?= nl2br(
                        htmlspecialchars(
                            $report['emergency_description']
                            ?? 'No emergency description available.'
                        )
                    ); ?>
                </p>

            </div>


            <?php
            if (
                ($report['victim_type'] ?? '')
                === 'other'
            ):
            ?>

                <div class="report-description">

                    <h4>Victim Information</h4>

                    <p>
                        <?= nl2br(
                            htmlspecialchars(
                                $report['victim_information']
                                ?? 'No additional victim information.'
                            )
                        ); ?>
                    </p>

                </div>

            <?php endif; ?>

        </div>


        <!-- HELP SEEKER -->

        <div class="report-section">

            <h3>Help Seeker Information</h3>

            <div class="report-grid">

                <div class="report-field">
                    <span>Name</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['help_seeker_name']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Email</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['help_seeker_email']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Phone</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['help_seeker_phone']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

            </div>

        </div>


        <!-- VOLUNTEER -->

        <div class="report-section">

            <h3>Assigned Volunteer</h3>

            <?php if (!empty($report['volunteer_id'])): ?>

                <div class="report-grid">

                    <div class="report-field">
                        <span>Name</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_name']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Phone</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_phone']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Email</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_email']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Availability</span>

                        <strong>
                            <?= htmlspecialchars(
                                ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $report[
                                            'volunteer_availability'
                                        ]
                                        ?? 'N/A'
                                    )
                                )
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Blood Group</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_blood_group']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Experience</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_experience']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Skills</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report['volunteer_skills']
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                    <div class="report-field">
                        <span>Emergency Contact</span>

                        <strong>
                            <?= htmlspecialchars(
                                $report[
                                    'volunteer_emergency_contact'
                                ]
                                ?? 'N/A'
                            ); ?>
                        </strong>
                    </div>

                </div>


                <div class="report-description">

                    <h4>Volunteer Address</h4>

                    <p>
                        <?= htmlspecialchars(
                            $report['volunteer_address']
                            ?? 'N/A'
                        ); ?>
                    </p>

                </div>


                <div class="report-grid">

                    <div class="report-field">
                        <span>Accepted At</span>

                        <strong>
                            <?php
                            echo !empty($report['accepted_at'])
                                ? htmlspecialchars(
                                    date(
                                        'd M Y, h:i A',
                                        strtotime(
                                            $report['accepted_at']
                                        )
                                    )
                                )
                                : 'N/A';
                            ?>
                        </strong>
                    </div>

                </div>

            <?php else: ?>

                <p>
                    No volunteer was assigned to this emergency request.
                </p>

            <?php endif; ?>

        </div>


        <!-- RESCUE OPERATION -->

        <div class="report-section">

            <h3>Rescue Operation Report</h3>

            <div class="report-description">

                <h4>Admin Report Description</h4>

                <p>
                    <?= nl2br(
                        htmlspecialchars(
                            $report['report_description']
                            ?? 'No report description available.'
                        )
                    ); ?>
                </p>

            </div>

        </div>


        <!-- ADMIN INFORMATION -->

        <div class="report-section">

            <h3>Report Administration</h3>

            <div class="report-grid">

                <div class="report-field">
                    <span>Prepared / Reviewed By</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['admin_name']
                            ?? 'System Admin'
                        ); ?>
                    </strong>
                </div>

                <div class="report-field">
                    <span>Admin Email</span>

                    <strong>
                        <?= htmlspecialchars(
                            $report['admin_email']
                            ?? 'N/A'
                        ); ?>
                    </strong>
                </div>

            </div>

        </div>


        <!-- PRINT FOOTER -->

        <div class="report-document-footer">

            <p>
                This report was generated by the
                Rescue Management System.
            </p>

        </div>

    </div>

</div>

<?php
require_once "views/partials/footer.php";
?>