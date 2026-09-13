<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/VolunteerModel.php";


$volunteer_id =
    (int)(
        $_SESSION['user']['id']
        ?? 0
    );


if ($volunteer_id <= 0) {

    die(
        "Invalid volunteer account."
    );
}


$message = '';
$error = '';


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


/*
|--------------------------------------------------------------------------
| UPDATE VOLUNTEER PROFILE
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {

    /*
    |--------------------------------------------------------------------------
    | CSRF PROTECTION
    |--------------------------------------------------------------------------
    */

    requireValidCsrfToken();


    /*
    |--------------------------------------------------------------------------
    | GET FORM DATA
    |--------------------------------------------------------------------------
    */

    $name =
        trim(
            $_POST['name']
            ?? ''
        );

    $phone =
        trim(
            $_POST['phone']
            ?? ''
        );

    $address =
        trim(
            $_POST['address']
            ?? ''
        );

    $blood_group =
        trim(
            $_POST['blood_group']
            ?? ''
        );

    $experience =
        trim(
            $_POST['experience']
            ?? ''
        );

    $skills =
        trim(
            $_POST['skills']
            ?? ''
        );

    $emergency_contact =
        trim(
            $_POST['emergency_contact']
            ?? ''
        );


    /*
    |--------------------------------------------------------------------------
    | PHP VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $phone === '' ||
        $address === '' ||
        $blood_group === '' ||
        $emergency_contact === ''
    ) {

        $error =
            "Please fill in all required fields.";

    } elseif (
        strlen($name) < 2 ||
        strlen($name) > 100
    ) {

        $error =
            "Name must be between 2 and 100 characters.";

    } elseif (
        !preg_match(
            '/^[0-9+\-\s()]{7,20}$/',
            $phone
        )
    ) {

        $error =
            "Please enter a valid phone number.";

    } elseif (
        strlen($address) > 255
    ) {

        $error =
            "Address must not exceed 255 characters.";

    } elseif (
        !in_array(
            $blood_group,
            $bloodGroups,
            true
        )
    ) {

        $error =
            "Please select a valid blood group.";

    } elseif (
        strlen($experience) > 255
    ) {

        $error =
            "Experience must not exceed 255 characters.";

    } elseif (
        strlen($skills) > 2000
    ) {

        $error =
            "Skills must not exceed 2000 characters.";

    } elseif (
        strlen($emergency_contact) > 100
    ) {

        $error =
            "Emergency contact must not exceed 100 characters.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $updated =
            updateVolunteerProfile(
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

            /*
            |--------------------------------------------------------------------------
            | UPDATE SESSION DATA
            |--------------------------------------------------------------------------
            */

            $_SESSION['user']['name'] =
                $name;

            $_SESSION['user']['phone'] =
                $phone;


            $message =
                "Profile updated successfully.";

        } else {

            $error =
                "Failed to update profile.";
        }
    }
}


/*
|--------------------------------------------------------------------------
| LOAD VOLUNTEER PROFILE
|--------------------------------------------------------------------------
*/

$profile =
    getVolunteerProfile(
        $conn,
        $volunteer_id
    );


if (!$profile) {

    die(
        "Volunteer profile could not be loaded."
    );
}


/*
|--------------------------------------------------------------------------
| KEEP SUBMITTED DATA AFTER VALIDATION ERROR
|--------------------------------------------------------------------------
*/

$selectedBloodGroup =
    $_POST['blood_group']
    ?? $profile['blood_group']
    ?? '';

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                My Profile
            </h1>

            <p>
                View and update your volunteer information.
            </p>

        </div>

    </div>


    <?php if ($message !== ''): ?>

        <div class="alert alert-success">

            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            ); ?>

        </div>

    <?php endif; ?>


    <?php if ($error !== ''): ?>

        <div class="alert alert-error">

            <?= htmlspecialchars(
                $error,
                ENT_QUOTES,
                'UTF-8'
            ); ?>

        </div>

    <?php endif; ?>


    <div class="card">

        <form
            method="POST"
            action="index.php?page=volunteer-profile"
        >

            <?= csrfField(); ?>


            <div class="form-group">

                <label for="name">
                    Name *
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    maxlength="100"
                    value="<?= htmlspecialchars(
                        $_POST['name']
                        ?? $profile['name']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    value="<?= htmlspecialchars(
                        $profile['email']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    readonly
                >

            </div>


            <div class="form-group">

                <label for="phone">
                    Phone *
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    maxlength="20"
                    value="<?= htmlspecialchars(
                        $_POST['phone']
                        ?? $profile['phone']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="address">
                    Address *
                </label>

                <input
                    type="text"
                    id="address"
                    name="address"
                    maxlength="255"
                    value="<?= htmlspecialchars(
                        $_POST['address']
                        ?? $profile['address']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="blood_group">
                    Blood Group *
                </label>

                <select
                    id="blood_group"
                    name="blood_group"
                    required
                >

                    <option value="">
                        Select Blood Group
                    </option>


                    <?php foreach ($bloodGroups as $group): ?>

                        <option
                            value="<?= htmlspecialchars(
                                $group,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                            <?= $selectedBloodGroup === $group
                                ? 'selected'
                                : ''; ?>
                        >

                            <?= htmlspecialchars(
                                $group,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label for="experience">
                    Experience
                </label>

                <input
                    type="text"
                    id="experience"
                    name="experience"
                    maxlength="255"
                    placeholder="Example: 2 years rescue experience"
                    value="<?= htmlspecialchars(
                        $_POST['experience']
                        ?? $profile['experience']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                >

            </div>


            <div class="form-group">

                <label for="skills">
                    Skills
                </label>

                <textarea
                    id="skills"
                    name="skills"
                    maxlength="2000"
                    placeholder="Example: First Aid, Swimming, Fire Rescue"
                ><?= htmlspecialchars(
                    $_POST['skills']
                    ?? $profile['skills']
                    ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?></textarea>

            </div>


            <div class="form-group">

                <label for="emergency_contact">
                    Emergency Contact *
                </label>

                <input
                    type="text"
                    id="emergency_contact"
                    name="emergency_contact"
                    maxlength="100"
                    value="<?= htmlspecialchars(
                        $_POST['emergency_contact']
                        ?? $profile['emergency_contact']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Profile
            </button>

        </form>

    </div>

</div>

<?php

require_once
    "views/partials/footer.php";

?>