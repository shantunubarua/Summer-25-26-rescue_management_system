<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/VolunteerModel.php";

$volunteer_id = (int)$_SESSION['user']['id'];

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $blood_group = trim($_POST['blood_group'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $skills = trim($_POST['skills'] ?? '');
    $emergency_contact =
        trim($_POST['emergency_contact'] ?? '');

    if (
        $name === '' ||
        $phone === '' ||
        $address === '' ||
        $blood_group === '' ||
        $emergency_contact === ''
    ) {
        $error = "Please fill in all required fields.";
    } else {

        $updated = updateVolunteerProfile(
            $conn,
            $volunteer_id,
            $name,
            $phone,
            $address,
            $blood_group,
            $experience,
            $skills,
            $emergency_contact
        );

        if ($updated) {

            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['phone'] = $phone;

            $message =
                "Profile updated successfully.";

        } else {

            $error =
                "Failed to update profile.";
        }
    }
}

$profile = getVolunteerProfile(
    $conn,
    $volunteer_id
);

?>

<div class="content">

    <h1>Volunteer Profile</h1>

    <p>
        View and update your volunteer information.
    </p>

    <?php if ($message !== ''): ?>
        <p class="success-message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <div>
            <label>Name *</label>

            <input
                type="text"
                name="name"
                value="<?php
                    echo htmlspecialchars(
                        $profile['name'] ?? ''
                    );
                ?>"
                required
            >
        </div>

        <div>
            <label>Email</label>

            <input
                type="email"
                value="<?php
                    echo htmlspecialchars(
                        $profile['email'] ?? ''
                    );
                ?>"
                readonly
            >
        </div>

        <div>
            <label>Phone *</label>

            <input
                type="text"
                name="phone"
                value="<?php
                    echo htmlspecialchars(
                        $profile['phone'] ?? ''
                    );
                ?>"
                required
            >
        </div>

        <div>
            <label>Address *</label>

            <input
                type="text"
                name="address"
                value="<?php
                    echo htmlspecialchars(
                        $profile['address'] ?? ''
                    );
                ?>"
                required
            >
        </div>

        <div>
            <label>Blood Group *</label>

            <select name="blood_group" required>

                <option value="">
                    Select Blood Group
                </option>

                <?php

                $bloodGroups = [
                    'A+',
                    'A-',
                    'B+',
                    'B-',
                    'AB+',
                    'AB-',
                    'O+',
                    'O-'
                ];

                foreach ($bloodGroups as $group):

                ?>

                    <option
                        value="<?php echo $group; ?>"
                        <?php
                        echo (
                            ($profile['blood_group'] ?? '')
                            === $group
                        ) ? 'selected' : '';
                        ?>
                    >
                        <?php echo $group; ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <div>
            <label>Experience</label>

            <input
                type="text"
                name="experience"
                placeholder="Example: 2 years rescue experience"
                value="<?php
                    echo htmlspecialchars(
                        $profile['experience'] ?? ''
                    );
                ?>"
            >
        </div>

        <div>
            <label>Skills</label>

            <textarea
                name="skills"
                placeholder="Example: First Aid, Swimming, Fire Rescue"
            ><?php
                echo htmlspecialchars(
                    $profile['skills'] ?? ''
                );
            ?></textarea>
        </div>

        <div>
            <label>Emergency Contact *</label>

            <input
                type="text"
                name="emergency_contact"
                value="<?php
                    echo htmlspecialchars(
                        $profile['emergency_contact'] ?? ''
                    );
                ?>"
                required
            >
        </div>

        <button type="submit">
            Update Profile
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>