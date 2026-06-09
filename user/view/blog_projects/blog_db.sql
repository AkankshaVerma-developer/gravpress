-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2025 at 08:05 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$GFKxzdwWpCDggCHYLhcZSOJhmhIayip.bz.UU.KbTBmHQ1M1mpTY6', '2025-10-17 23:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Digital Marketing', 'Startups'),
(5, 'web application', '');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_email` varchar(150) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_name`, `user_email`, `comment`, `status`, `created_at`) VALUES
(1, 1, 'Akanksha Verma', 'akanksha2272@gmail.com', 'excellent overview', 'approved', '2025-10-11 10:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`name`, `email`, `subject`, `message`, `created_at`) VALUES
('Akanksha Verma', 'akanksha2272@gmail.com', 'regarding blog', 'I like your blogs', '2025-10-18 13:58:29'),
('Akanksha Verma', 'akanksha2272@gmail.com', 'regarding blog', 'i like your blog', '2025-10-18 14:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `Author` varchar(100) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category_id`, `image`, `meta_description`, `created_at`, `Author`, `likes`, `slug`, `meta_title`, `meta_keywords`, `image_alt`) VALUES
(1, 'The Future of Digital Marketing', 'In this post, we explore the rise of AI-driven campaigns and automation tools shaping the industry.\r\n\r\nMarketing trends in 2025 have multiple factors here are the top digital marketing predictions for 2025:\r\n\r\n1. AI Will Dominate Marketing\r\nAI will become integral to marketing strategies, enabling real-time campaign optimization and predictive analytics. Chatbots, for instance, will handle complex queries with ease, offering human-like interactions.\r\n\r\n2. Social Commerce Will Surge\r\nAs social platforms like Instagram and TikTok expand e-commerce capabilities, social commerce will thrive. Brands can integrate shoppable posts and in-app purchases to blur the lines between content and commerce.\r\n\r\n3. Sustainability Will Shape Consumer Choices\r\nSustainability is no longer optional; it’s essential. Purpose-driven campaigns highlighting environmental and social responsibility will connect with modern consumers rather than occasionally addressing the issues and responsibilities.\r\n\r\nEmerging Marketing Technologies:-\r\n\r\nMarketing technologies now not just include the latest social media apps or scheduling tools; the game has changed in recent years. Innovative technologies are the driving force behind the evolution of digital marketing. Here are some emerging tools transforming the industry:\r\n\r\n1. Artificial Intelligence (AI)\r\nAI-driven solutions such as ChatGPT and Google’s Bard generate content, personalize recommendations, and optimize ad targeting. .\r\n\r\n2. Blockchain in Advertising\r\nBlockchain ensures ad transparency by verifying legitimate impressions and eliminating fraudulent activity. It’s gaining traction as a trust-building tool in digital marketing.\r\n\r\n3. Predictive Analytics\r\nUsing historical data, predictive analytics helps marketers anticipate trends and consumer needs. Predictive tools can inform product launches and refine target audiences.\r\n\r\n4. Internet of Things (IoT)\r\nIoT devices, from smartwatches to connected home appliances providing marketers deeper insights into user behavior. These insights lead to more accurate and personalized marketing strategies.\r\n\r\nThe Role of AI in Digital Marketing\r\nAI is shaping the future of digital marketing, streamlining processes and enhancing creativity. The marketing trends and techniques have changed significantly with the introduction of artificial intelligence in digital marketing. The following are some of the ways that highlight the role of AI in digital marketing:-\r\n\r\n1. Chatbots and Virtual Assistants\r\nAI-powered chatbots deliver instant, personalized responses, improving customer service efficiency. Brands like H&M use chatbots to assist customers with product searches and style advice.\r\n\r\n2. Automated Campaigns\r\nAI automates repetitive tasks like email scheduling, social media posting, and data analysis, freeing marketers to focus on strategy and creative development.\r\n', 5, 'marketing.jpg', 'Discover trends shaping the future of digital marketing.', '2025-10-17 00:00:00', 'Sumrit Shahi', 4, '', NULL, NULL, NULL),
(2, 'Building Brand Presence Online', 'Learn how to strengthen your brand identity with modern social strategies.\r\nFoundational steps\r\nBuild a professional website: Create a professional, user-friendly website with a clear, memorable domain name. It serves as the central hub for your online activities.\r\nOptimize for search engines (SEO): Use relevant keywords to make your website easily discoverable on search engines like Google.\r\nIdentify your target audience: Understand your audience\'s demographics, interests, and online behavior to tailor your content and strategy effectively.\r\nEnsure consistency: Maintain a consistent brand voice, image, and tone across all online channels to build a strong, unified brand identity. \r\nContent and engagement\r\nCreate valuable content: Develop a content strategy that provides value to your audience, using a mix of formats like blog posts, videos, and social media updates.\r\nUse social media strategically: Select the right platforms where your audience is most active and post regularly to maintain engagement. Use a mix of content like polls, stories, and videos to keep followers interested.\r\nEngage with your audience: Respond to comments and messages, ask questions, and encourage user-generated content to build a genuine connection.\r\nCollaborate with influencers: Partner with influencers whose audiences align with your brand to extend your reach and build trust.\r\nJoin online directories and groups: List your business in online directories, especially if you are a local business, and participate in relevant social media groups to increase visibility. ', 1, 'brand.jpg', 'Tips to grow your digital presence effectively.', '2025-10-16 00:00:00', 'Manju Gupta', 2, '', NULL, NULL, NULL),
(27, 'Digital Marketers', '<h3 id=\\\"the-difference-between-b2b-and-b2c-digital-marketing\\\" style=\\\"scroll-margin-top: 96px; font-size: 24px; line-height: 30px; color: rgb(44, 44, 44); font-family: &quot;Adobe Clean&quot;, adobe-clean, &quot;Trebuchet MS&quot;, sans-serif;\\\"><i>The difference between B2B and B2C digital marketing.</i></h3><ul style=\\\"color: rgb(44, 44, 44); font-family: &quot;Adobe Clean&quot;, adobe-clean, &quot;Trebuchet MS&quot;, sans-serif; font-size: 20px;\\\"><li>B2B decisions involve multiple people, while B2C typically only involves a single person.</li><li>B2B clients tend to have a longer decision-making process, so digital marketing should focus on building relationships.</li><li>The B2C buying process is generally shorter, so this requires short-term, urgent messaging.</li><li>B2B transactions are more driven by logic, while B2C is driven more by emotion.</li></ul><p style=\\\"color: rgb(44, 44, 44); font-family: &quot;Adobe Clean&quot;, adobe-clean, &quot;Trebuchet MS&quot;, sans-serif; font-size: 20px; font-weight: 400;\\\">Fortunately, <a href=\\\"https://buisness.adobe.com\\\" target=\\\"_blank\\\" rel=\\\"noopener noreferrer\\\">digital marketing</a> works for both approaches. Whether you’re targeting businesses or consumers, digital marketing will help you streamline the marketing process for results.</p>', 1, '1762242542_what-is-digital-marketing.webp', NULL, '2025-11-04 13:19:02', '', 0, '', 'B2B and B2C digital marketing', NULL, NULL),
(28, 'Web Application', '<span style=\\\"color: rgb(10, 10, 10); font-family: &quot;Google Sans&quot;, Roboto, Arial, sans-serif; font-size: 16px;\\\">These <a href=\\\"https://google.com/\\\" target=\\\"_blank\\\" rel=\\\"noopener noreferrer\\\">applications</a> use technologies like HTML, CSS, and JavaScript for the user interface, and back-end languages for the server-side logic, making them accessible and usable from almost any device with a connection</span>', 5, '1762256633_what-is-digital-marketing.webp', NULL, '2025-11-04 17:13:53', '', 0, '', 'web marketing', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_ip` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_ip`, `created_at`) VALUES
(16, 1, '::1', '2025-11-02 06:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` int(30) NOT NULL,
  `site_name` varchar(200) DEFAULT NULL,
  `site_description` text DEFAULT NULL,
  `site_keywords` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `site_name`, `site_description`, `site_keywords`) VALUES
(1, 'Blog Website', 'Welcome to my  awesome blog', 'blog, php, html, css, content');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$GS57EgVJYFzuvstsCF9akeSaD1wnbqF0RwSFuOiC2f5OaDX338VBi', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`user_ip`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
