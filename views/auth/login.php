<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Rescue Management System</title>
</head>

<body>

    <h1>Rescue Management System</h1>

    <h2>Login</h2>

    <form method="POST" action="index.php?page=login">

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <button type="submit" name="login">Login</button>

    </form>

</body>
</html>