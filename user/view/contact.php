<?php
include '../../connection/db.php';
include 'header.php';
  ?>
<html>
    <head>
        <link rel="stylesheet" href="../css/contact.css">
</head>
</html>
<main class="contact-page bubble-bg">

  <!-- Hero Section -->
  <section class="contact-hero">
    <div class="hero-inner">
      <h1>Contact <span>GravPress</span></h1>
      <p>Lets Connect!!! We’d love to hear from you — whether you have questions, ideas, or want to collaborate!</p>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="contact-form">
    <div class="form-box">
      <h2>Send Us a Message</h2>
      <form action="contact.php" method="POST" autocomplete="off">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" rows="5" placeholder="Your Message..." required></textarea>
        <button class="buton" type="submit">Send Message</button>
      </form>


      <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $subject = $conn->real_escape_string($_POST['subject']);
  $message = $conn->real_escape_string($_POST['message']);

  $sql = "INSERT INTO contact_messages (name, email, subject, message)
          VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "<p class='success'>✅ Message stored successfully! Thank you, $name.</p>";
  } else {
    echo "<p class='error'>❌ Something went wrong: " . $conn->error . "</p>";
  }
}
?>   
    </div>
  </section>

  <!-- Map Section -->
    <!-- Map Section -->
  <section class="map">
    <h2>Find Us On the Map</h2>
    <div class="map-box">
      <div class="map-left">
        <h3>GravPress Headquarters</h3>
        <p>
          We're located in the heart of Bilaspur — surrounded by innovation, technology, and creativity.
          Our workspace is designed to inspire developers and creators alike. Drop by our office or 
          reach out through email and phone to connect with our support and development teams.
        </p>
      </div>

      <div class="map-right">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.912705702196!2d75.85873907499303!3d22.73083992938856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fd21a8c03f9b%3A0xadbdbbf6d42d144a!2sGraventon%20Solutions!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
          width="100%" height="350" style="border:0;" allowfullscreen loading="lazy">
        </iframe>
      </div>
    </div>
  </section>


  <!-- Timezone / Office Hours -->
  <section class="info">
    <h2>Office Hours & Timezone</h2><br>
    <div class="info-grid">
      <div class="info-box">
        <h3>⏰ Office Hours</h3><br>
        <p>Monday - Friday: 9:00 AM to 6:00 PM</p>
       
      </div>
      <div class="info-box">
        <h3>🌐 Timezone</h3><br>
        <p>Indian Standard Time (GMT +5:30)</p>
        <p>Location: Bilaspur, India</p>
      </div>
      <div class="info-box">
        <h3>📞 Connect With Us</h3><br>
        <p>Email: support@gravpress.in</p>
        <p>Phone: +91 98765 43210</p>
      </div>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>
