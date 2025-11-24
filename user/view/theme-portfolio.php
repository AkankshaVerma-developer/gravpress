<?php
// STATIC PORTFOLIO THEME PREVIEW
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GravPress Portfolio Theme – Preview</title>
    <link rel="stylesheet" href="../css/theme-portfolio.css">
</head>

<body>
 <header class="gp-header">
  <div class="gp-container">
    <div class="gp-logo">GravPress</div>
    <nav class="gp-nav">
      <a href="home.php">Home</a>
      <a href="gravtheme.php" class="active">Themes</a>
    <a href="activate.php?theme=theme-portfolio" class="btn">Activate Theme</a>

      <a href="#">Support</a>
    </nav>
  </div>
</header>
<!-- ================= HEADER ================= -->
<header class="header">
    <div class="logo"><span>Portfolio</span></div>

    <nav class="nav">
        <a href="#">Home</a>
        <a href="#">Work</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
</header>



<!-- ================= HERO ================= -->
<section class="hero">
    <div class="hero-left">
        <h1>Hello, I'm <span>Akanksha</span></h1>
        <p>A Creative Web Developer who loves building beautiful UI.</p>
        <a href="#" class="btnn">View My Work</a>
    </div>

    <div class="hero-right">
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e" alt="Profile">
    </div>
</section>



<!-- ================= ABOUT SECTION ================= -->
<section class="about">
    <div class="about-text">
        <h2>About Me</h2>
        <p>I create efficient, modern and beautiful websites. I have experience in PHP, JS, MySQL and modern UI/UX design styles.</p>
    </div>

    <div class="about-stats">
        <div class="stat">
            <h3>3+</h3>
            <p>Years Experience</p>
        </div>

        <div class="stat">
            <h3>50+</h3>
            <p>Projects Completed</p>
        </div>

        <div class="stat">
            <h3>10+</h3>
            <p>Technologies</p>
        </div>
    </div>
</section>



<!-- ================= SKILLS GRID (Unique Layout) ================= -->
<section class="skills">
    <h2 class="section-title">My Skills</h2>

    <div class="skills-grid">

        <div class="skill-card big">
            <h3>Front-End</h3>
            <p>HTML, CSS, JS, Bootstrap, React</p>
        </div>

        <div class="skill-card">
            <h3>Back-End</h3>
            <p>PHP, Node, MySQL</p>
        </div>

        <div class="skill-card tall">
            <h3>UI / UX</h3><br>
            <p>Modern<br> Responsive<br> Clean Layouts</p>
        </div>

        <div class="skill-card">
            <h3>Tools</h3>
            <p>Git, VS Code, Figma, Postman</p>
        </div>

    </div>
</section>



<!-- ================= PORTFOLIO GRID ================= -->
<section class="portfolio">
    <h2 class="section-title">Latest Projects</h2>

    <div class="portfolio-grid">

        <div class="portfolio-item">
            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085" alt="">
            <div class="overlay">
                <h3>Task Manager App</h3>
                <span>Web Application</span>
            </div>
        </div>

        <div class="portfolio-item tall">
            <img src="https://images.unsplash.com/photo-1551033406-611cf9a28f67" alt="">
            <div class="overlay">
                <h3>Portfolio Website</h3>
                <span>UI Design</span>
            </div>
        </div>

        <div class="portfolio-item wide">
            <img src="https://images.unsplash.com/photo-1555421689-491a97ff2040" alt="">
            <div class="overlay">
                <h3>E-Commerce Template</h3>
                <span>Front-End</span>
            </div>
        </div>

        <div class="portfolio-item">
            <img src="https://images.unsplash.com/photo-1532619187608-e5375cab36aa" alt="">
            <div class="overlay">
                <h3>Blog CMS</h3>
                <span>PHP + MySQL</span>
            </div>
        </div>

    </div>
</section>



<!-- ================= CONTACT ================= -->
<section class="contact">
    <h2>Let's Work Together</h2>
    <p>Have a project in mind? Let’s build something amazing.</p>
    <a href="#" class="btnn">Contact Me</a>
    <div class="container">
  <form action="#">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

    <label for="country">Country</label>
    <select id="country" name="country">
      <option value="australia">India</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
    </select>

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

    <input type="submit" value="Submit">
  </form>
</div>
</section>



<!-- ================= FOOTER ================= -->
<footer class="footer">
    © 2025 GravPress — Portfolio Theme Preview
</footer>

</body>
</html>
