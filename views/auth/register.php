<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Register - Rescue Management System
    </title>

    <link
        rel="stylesheet"
        href="assets/css/style.css?v=14"
    >
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">

            <h1>
                Create Account
            </h1>

            <p>
                Register for Rescue Management System
            </p>


            <?php if (!empty($error)): ?>

                <div class="alert alert-error">
                    <?php
                    echo htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </div>

            <?php endif; ?>


            <form
                method="POST"
                action="index.php?page=register"
                id="registerForm"
            >

                <?php echo csrfField(); ?>


                <div class="form-group">

                    <label for="name">
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        maxlength="100"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['name'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                        required
                    >

                </div>

                <div class="form-group">

    <label for="username">
        Username
    </label>

    <input
        type="text"
        id="username"
        name="username"
        value="<?php
            echo htmlspecialchars(
                $_POST['username'] ?? ''
            );
        ?>"
        placeholder="Choose a unique username"
        minlength="3"
        maxlength="30"
        pattern="[A-Za-z0-9_]+"
        required
    >

    <small>
        3-30 characters. Letters, numbers and underscore only.
    </small>

</div>


                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        maxlength="150"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['email'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="phone">
                        Phone
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        maxlength="20"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['phone'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="role">
                        Register As
                    </label>

                    <select
                        id="role"
                        name="role"
                        required
                    >

                        <option value="">
                            Select Role
                        </option>

                        <option
                            value="volunteer"
                            <?php
                            echo (
                                ($_POST['role'] ?? '') ===
                                'volunteer'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Volunteer
                        </option>

                        <option
                            value="witness"
                            <?php
                            echo (
                                ($_POST['role'] ?? '') ===
                                'witness'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Witness
                        </option>

                        <option
                            value="help_seeker"
                            <?php
                            echo (
                                ($_POST['role'] ?? '') ===
                                'help_seeker'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Help Seeker
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="confirm_password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        minlength="8"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Create Account
                </button>

            </form>


            <p>
                Already have an account?

                <a href="index.php?page=login">
                    Login
                </a>
            </p>

        </div>

    </div>

</body>

</html>