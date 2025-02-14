<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "adminSidebar.php";
    include "adminMainContent.php";
    ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Style</th>
                    <th>Title</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Time-Slot</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>manoj@gmail.com</td>
                    <td><img src="./IMAGES/buzz.jpeg" alt=""></td>
                    <td>Buzz</td>
                    <td>Lorem ipsum dol</td>
                    <td>2025-02-30</td>
                    <td>7-7:30</td>
                    <td>
                        <button class="completed">Completed</button>
                        <button class="cancelled">Cancelled</button>
                        <button class="complete">Complete</button>
                    </td>
                </tr>

                <tr>
                    <td>manoj@gmail.com</td>
                    <td><img src="./IMAGES/buzz.jpeg" alt=""></td>
                    <td>Buzz</td>
                    <td>Loreme et ad pariatur provqui.</td>
                    <td>2025-02-30</td>
                    <td>7-7:30</td>
                    <td>
                        <button class="completed">Completed</button>
                        <button class="cancelled">Cancelled</button>
                        <button class="complete">Complete</button>
                    </td>
                </tr>

                <tr>
                    <td>manoj@gmail.com</td>
                    <td><img src="./IMAGES/buzz.jpeg" alt=""></td>
                    <td>Buzz</td>
                    <td>dit beatsdfgdfgsdfgdfgsed maiores sequi.</td>
                    <td>2025-02-30</td>
                    <td>7-7:30</td>
                    <td>
                        <button class="completed">Completed</button>
                        <button class="cancelled">Cancelled</button>
                        <button class="complete">Complete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>