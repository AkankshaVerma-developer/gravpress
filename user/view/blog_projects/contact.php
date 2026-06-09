<?php require_once __DIR__ . '/partials/db.php';?> 
<?php include 'partials/header.php'; ?> 
<section class="contact-section"> 
  <div class="overlay"></div> 
  <div class="container contact-container"> 
    <h1>Contact Us</h1> <p>We'd love to hear from you. Get in touch using the form below or find us at our office</p>
     <div class="contact-content">
       <!-- Contact Form --> 
      <div class="contact-form"> <form action="send_message.php" method="POST"> 
        <input type="text" name="name" placeholder="Your Name" required> 
        <input type="email" name="email" placeholder="Your Email" required> 
        <input type="text" name="subject" placeholder="Subject" required>
         <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
          <button type="submit" class="btn-submit">Send Message</button> </form> </div>
           <!-- Contact Info --> <div class="contact-info">
             <h3>Get In Touch</h3> 
             <p><i class="fa fa-map-marker"></i> Bridge pratap chowk, Bilaspur, India</p>
              <p><i class="fas fa-envelope"></i> info@graventonsolutions.com</p>
              <p><i class="far fa-clock"></i>Office time: 9am to 6pm</p>
               <p><i class="fas fa-phone-alt"></i> +91 98765 43210</p>
                
                <div class="map-container"> <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3696.9475814047414!2d82.14721017474339!3d22.08981875049287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a280bd519610325%3A0x511ab1d5ca67520d!2sGraventon%20Solutions%20-%20Digital%20Marketing%20and%20Web%20Development%20Agency!5e0!3m2!1sen!2sin!4v1758550586839!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                 </div>
                 </div>
                 </div> 
                </section>
                 <?php include 'partials/footer.php'; ?>