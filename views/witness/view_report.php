<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="witness-report-view-page">

        <?php if (!$report): ?>

            <div class="witness-page-header">

                <div>
                    <p class="eyebrow">
                        INCIDENT DETAILS
                    </p>

                    <h1>
                        Report Not Found
                    </h1>

                    <p class="page-subtitle">
                        The requested incident report could not be found.
                    </p>
                </div>

            </div>

            <div class="witness-report-empty">

                <h2>
                    Incident report unavailable
                </h2>

                <p>
                    The report may have been removed or
                    may not belong to your account.
                </p>

                <a
                    href="index.php?page=witness-reports"
                    class="primary-action"
                >
                    Back to My Reports
                </a>

            </div>

        <?php else: ?>

            <?php

            $damage =
                strtolower(
                    $report['damage_level']
                    ?? 'low'
                );

            $status =
                strtolower(
                    $report['status']
                    ?? 'pending'
                );

            ?>

            <!-- PAGE HEADER -->

            <div class="witness-page-header">

                <div>

                    <p class="eyebrow">
                        INCIDENT DETAILS
                    </p>

                    <h1>
                        Report #<?= (int)$report['id']; ?>
                    </h1>

                    <p class="page-subtitle">
                        Review the information, damage assessment,
                        evidence and current admin review status.
                    </p>

                </div>


                <div class="witness-page-header-actions">

                    <a
                        href="index.php?page=witness-reports"
                        class="secondary-action"
                    >
                        Back to Reports
                    </a>

                    <a
                        href="index.php?page=witness-report-edit&id=<?= (int)$report['id']; ?>"
                        class="primary-action"
                    >
                        Edit Report
                    </a>

                </div>

            </div>


            <!-- MAIN REPORT CARD -->

            <div class="witness-report-detail-card">

                <div class="witness-report-detail-header">

                    <div>

                        <span class="witness-detail-label">
                            INCIDENT REPORT
                        </span>

                        <h2>
                            <?= htmlspecialchars(
                                $report['title']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>
                        </h2>

                    </div>


                    <div class="witness-report-badges">

                        <span
                            class="
                                witness-damage-badge
                                witness-damage-<?= htmlspecialchars(
                                    $damage,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            "
                        >
                            <?= htmlspecialchars(
                                ucfirst($damage),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>
                            Damage
                        </span>


                        <span
                            class="
                                witness-status-badge
                                witness-status-<?= htmlspecialchars(
                                    $status,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            "
                        >
                            <?= htmlspecialchars(
                                ucfirst($status),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>
                        </span>

                    </div>

                </div>


                <!-- REPORT INFORMATION -->

                <div class="witness-detail-section">

                    <div class="witness-detail-section-title">

                        <span>
                            REPORT INFORMATION
                        </span>

                        <h3>
                            Incident Overview
                        </h3>

                    </div>


                    <div class="witness-detail-grid">


                        <div class="witness-detail-item">

                            <span>
                                Report ID
                            </span>

                            <strong>
                                #<?= (int)$report['id']; ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Incident Type
                            </span>

                            <strong>
                                <?= htmlspecialchars(
                                    ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $report[
                                                'incident_type'
                                            ]
                                            ?? ''
                                        )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Location
                            </span>

                            <strong>
                                <?= htmlspecialchars(
                                    $report['location']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Incident Date
                            </span>

                            <strong>
                                <?php if (
                                    !empty(
                                        $report['incident_date']
                                    )
                                ): ?>

                                    <?= htmlspecialchars(
                                        date(
                                            'd M Y',
                                            strtotime(
                                                $report[
                                                    'incident_date'
                                                ]
                                            )
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                <?php else: ?>

                                    Not available

                                <?php endif; ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Damage Level
                            </span>

                            <strong>
                                <?= htmlspecialchars(
                                    ucfirst($damage),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Review Status
                            </span>

                            <strong>
                                <?= htmlspecialchars(
                                    ucfirst($status),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </strong>

                        </div>


                        <div class="witness-detail-item">

                            <span>
                                Submitted At
                            </span>

                            <strong>
                                <?php if (
                                    !empty(
                                        $report['created_at']
                                    )
                                ): ?>

                                    <?= htmlspecialchars(
                                        date(
                                            'd M Y, h:i A',
                                            strtotime(
                                                $report[
                                                    'created_at'
                                                ]
                                            )
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                <?php else: ?>

                                    Not available

                                <?php endif; ?>
                            </strong>

                        </div>

                    </div>

                </div>


                <!-- DESCRIPTION -->

                <div class="witness-detail-section">

                    <div class="witness-detail-section-title">

                        <span>
                            INCIDENT DESCRIPTION
                        </span>

                        <h3>
                            What Happened
                        </h3>

                    </div>


                    <div class="witness-description-box">

                        <?= nl2br(
                            htmlspecialchars(
                                $report['description']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        ); ?>

                    </div>

                </div>


                <!-- EVIDENCE -->

                <div class="witness-detail-section">

                    <div class="witness-detail-section-title">

                        <span>
                            SUPPORTING MATERIAL
                        </span>

                        <h3>
                            Evidence
                        </h3>

                    </div>


                    <?php if (
                        !empty(
                            $report['evidence_file']
                        )
                    ): ?>

                        <div class="witness-evidence-box">

                            <div class="witness-evidence-icon">
                                FILE
                            </div>

                            <div class="witness-evidence-info">

                                <strong>
                                    Evidence file attached
                                </strong>

                                <span>
                                    Open the uploaded evidence
                                    in a new browser tab.
                                </span>

                            </div>

                            <a
                                href="<?= htmlspecialchars(
                                    $report[
                                        'evidence_file'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                target="_blank"
                                rel="noopener"
                                class="secondary-action"
                            >
                                View Evidence
                            </a>

                        </div>

                    <?php else: ?>

                        <div class="witness-no-evidence">

                            No evidence file was uploaded
                            with this report.

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>