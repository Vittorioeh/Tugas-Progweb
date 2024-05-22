<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDTH-Payment</title>
    <link rel="stylesheet" href="Pembayaran.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Indie+Flower|Inknut+Antiqua|Lora|Ravi+Prakash" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"  />
    <script src="https://kit.fontawesome.com/4592f70558.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="#"><img src="Foto/I.png" alt=""></a>
            </div>
            <ul>
                <li><a href="Home.html">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Feedback</a></li>
            </ul>
        </div>
    </header>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require 'dbconnect.php';

        // Ambil data jumlah tiket dari inputan formulir
        $quantities = $_POST['quantity'];

        // Variabel untuk menyimpan total harga pembelian
        $total_price = 0;
        $total_quantity = 0;
        $cat = "";

        // Header
        echo '<h2 style="text-align: center;">Invoice</h2>';

        // Mulai tabel untuk menampilkan detail tiket
        echo '<div style="overflow-x:auto; margin: auto; width: 40%;">';
        echo '<table style="border-collapse: collapse; width: 100%;">';
        echo '<tr>';
        echo '<th style="border: 1px solid black;">Ticket Type</th>';
        echo '<th style="border: 1px solid black;">Price</th>';
        echo '<th style="border: 1px solid black;">Quantity</th>';
        echo '<th style="border: 1px solid black;">Total Price</th>';
        echo '</tr>';

        // Loop melalui setiap jenis tiket yang dipilih
        foreach ($quantities as $ticket_id => $quantity) {
            if ($quantity > 0) {
                // Ambil data tiket dari database
                $result = $mysqli->query("SELECT * FROM tickets WHERE id = " . intval($ticket_id));
                $ticket = $result->fetch_assoc();

                if ($ticket) {
                    // Hitung total harga untuk jenis tiket ini
                    $subtotal = floatval($ticket['price']) * intval($quantity);
                    $total_price += $subtotal;
                    $total_quantity += intval($quantity);
                    $cat .= $ticket['type'] . "-" . htmlspecialchars($quantity) . " ";

                    // Tampilkan detail tiket dalam baris tabel
                    echo '<tr>';
                    echo '<td style="border: 1px solid black; text-align: center;">' . htmlspecialchars($ticket['type']) . '</td>';
                    echo '<td style="border: 1px solid black; text-align: center;">' . 'Rp ' . number_format($ticket['price'], 0, ',', '.') . '</td>';
                    echo '<td style="border: 1px solid black; text-align: center;">' . htmlspecialchars($quantity) . '</td>';
                    echo '<td style="border: 1px solid black; text-align: center;">' . 'Rp ' . number_format($subtotal, 0, ',', '.') . '</td>';
                    echo '</tr>';
                }
            }
        }

        // Tutup tabel
        echo '</table>';
        echo '</div>';

        // Tampilkan total harga
        echo "<br>";
        // Tampilkan total harga dalam bentuk rupiah
        echo '<p style="text-align:center;">Total Price: Rp ' . number_format($total_price, 0, ',', '.') . '</p>';

        // Formulir pembayaran
        echo '<form action="Pembayaran.php" method="post">';
        echo '<input type="hidden" name="total_price" value="' . $total_price . '">';
        echo '<input type="hidden" name="total_quantity" value="' . $total_quantity . '">';
        echo '<input type="hidden" name="cat" value="' . $cat . '">';
        echo '</form>';
    }
    ?>

    <div class="container">
        <form action="Pembayaran.php" method="post">
            <div class="row">
                <div class="col">
                    <h3 class="title">PEMBAYARAN KONSER</h3>
                    <div class="inputbox">
                        <span>Full name :</span>
                        <input type="text" placeholder="Nama Lengkap Anda.." required>
                    </div>
                    <div class="inputbox">
                        <span>Email :</span>
                        <input type="email" placeholder="example@gmail.com" required>
                    </div>
                    <div class="inputbox">
                        <span>address :</span>
                        <input type="text" placeholder="room - street">
                    </div>
                    <div class="inputbox">
                        <span>city :</span>
                        <input type="text" placeholder="Your City">
                    </div>
                    <div class="flex">
                        <div class="inputbox">
                            <span>state :</span>
                            <input type="text" placeholder="Indonesia">
                        </div>
                        <div class="inputbox">
                            <span>Kode Pos :</span>
                            <input type="text" placeholder="1234">
                        </div>
                    </div>
                </div>
    
                <div class="col">
                    <h3 class="title">Payment</h3>
                    <div class="inputbox">
                        <span>cards accepted :</span>
                        <img src="https://klikhoreca.com/assets/images/footer/metode_pembayaran_rev21aug.png" alt="">
                    </div>
                    <div class="inputbox">
                        <span>NO HP :</span>
                        <input type="text" name="phone_number" placeholder="+62">
                    </div>
                    <div class="inputbox">
                        <span>Jumlah Pemesanan :</span>
                        <input type="number" name="total_quantity" id="total_quantity" value="<?php echo $total_quantity?>" readonly>
                    </div>
                    <div class="inputbox">
                        <span>NIK :</span>
                        <input type="text" name="nik" placeholder="Nomor Induk Kependudukan">
                    </div>
                    <div class="flex">
                        <div class="inputbox">
                            <span>Umur :</span>
                            <input type="number" name="age" placeholder="1234">
                        </div>
                        <div class="inputbox">
                            <span>cat :</span>
                            <input type="text" name="cat" id="cat" value="<?php echo $cat?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <a href="About.php" class="button-85" role="button">BACK</a>
            <input type="submit" value="procces to checkout" class="submit-btn">
        </form>
    </div>


    <footer class="footer">
        <div class="f2">
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
        <br><hr><br>
        <p> &copy;Indonesia Ticket Hub 2024</p>
   </footer>
   <div id="popup-box" class="modal">
    <div class="content">
        <h1 > Transaction Successful !</h1>
        <p> your ticket will be sent via email</p>
        <a href="Home.html" class="T">&times;</a>
    </div>

    

</body>
</html>