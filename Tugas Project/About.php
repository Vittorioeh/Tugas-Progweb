<?php
require 'dbconnect.php';

// Ensure that the artist_id is provided
$artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 1;

// Fetch general artist data
$artist_result = $mysqli->query("SELECT namaKonser, image, tentangKonser,imageSeat FROM events WHERE artist_id = $artist_id");
$artist_data = $artist_result->fetch_assoc();

$songs_result = $mysqli->query("SELECT * FROM songs WHERE artist_id = $artist_id");
$tour_dates_result = $mysqli->query("SELECT * FROM tour_dates WHERE artist_id = $artist_id");
$tickets_result = $mysqli->query("SELECT * FROM tickets WHERE artist_id = $artist_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Data</title>
    <link rel="stylesheet" href="About.css">
    <script src="https://kit.fontawesome.com/4592f70558.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="#"><img src="Foto/I.png" alt=""></a>
            </div>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>
        </div>
    </header>
    <main>
        <h1><?= htmlspecialchars($artist_data['namaKonser']) ?></h1>
        <center>
        <table class="intro">
            <tr>
                <td>
                    <section class="image">
                        <img src="data:image/jpeg;base64,<?= base64_encode($artist_data['image']) ?>" alt="<?= htmlspecialchars($artist_data['namaKonser']) ?> Tour Image">
                    </section>
                </td>
                <td>
                    <section class="about-us">
                        <h2>About <?= htmlspecialchars($artist_data['namaKonser']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($artist_data['tentangKonser'])) ?></p>
                    </section>
                </td>
            </tr>
        </table>
        </center>
        <section class="our-album">
            <hr>
            <h2>Songs</h2>
            <table>
                <tr class="mp3">
                    <?php while ($song = $songs_result->fetch_assoc()): ?>
                        <td>
                            <a href="<?= htmlspecialchars($song['url']) ?>" target="_blank">
                                <?php if ($song['image']): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($song['image']) ?>" alt="<?= htmlspecialchars($song['title']) ?>">
                                <?php else: ?>
                                    <img src="path/to/default/image.jpg" alt="No Image Available">
                                <?php endif; ?>
                            </a>
                        </td>
                    <?php endwhile; ?>
                </tr>
                <tr class="link">
                    <?php $songs_result->data_seek(0); ?>
                    <?php while ($song = $songs_result->fetch_assoc()): ?>
                        <td>
                            <a href="<?= htmlspecialchars($song['url']) ?>" target="_blank">
                                <?= htmlspecialchars($song['title']) ?>
                            </a>
                        </td>
                    <?php endwhile; ?>
                </tr>
            </table>
        </section>

        <section class="tour-dates">
            <hr>
            <h2>Tour Dates</h2>
            <table>
                <thead>
                <tr>
                    <th>City</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($tour_date = $tour_dates_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($tour_date['city']) ?></td>
                        <td><?= htmlspecialchars($tour_date['date']) ?></td>
                        <td><?= htmlspecialchars($tour_date['time']) ?></td>
                        <td><?= htmlspecialchars($tour_date['venue']) ?></td>
                    </tr>
                    
                <?php endwhile; ?>
                
                </tbody>
            </table>
        </section>

        <s<section class="venue">
    <hr>
    <h2>Seating Plan & Tickets</h2>
    <form action="Pembayaran.php" method="post">
      <img src="data:image/jpeg;base64,<?= base64_encode($artist_data['imageSeat']) ?>" alt="<?= htmlspecialchars($artist_data['namaKonser']) ?> Tour Seating Plan Image">
        <table class="stock">
            <tr>
                <th>Ticket Type</th>
                <th>Stock Remaining</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php while ($ticket = $tickets_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['type']) ?></td>
                    <td><?= htmlspecialchars($ticket['stock']) ?></td>
                    <td><?= htmlspecialchars($ticket['price']) ?></td>
                    <td>
                        <input type="number" name="quantity[<?= htmlspecialchars($ticket['id']) ?>]" min="0" max="<?= htmlspecialchars($ticket['stock']) ?>" value="0">
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <button type="submit" class="buy-tickets-btn" onclick="confirmBooking()">Buy Tickets Now!</button>
    </form>
  </section>

  </main>
    <footer class="footer">
        <div class="container3">
            <div class="row">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        <li><a href="#">about us</a></li>
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">affiliate program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">shipping</a></li>
                        <li><a href="#">returns</a></li>
                        <li><a href="#">order status</a></li>
                        <li><a href="#">payment options</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <p>&copy;Indonesia Ticket Hub 2024</p>
    </footer>
    <script src="About.js"></script>
</body>
</html>
