-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    registration_link VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample events
INSERT INTO events (title, event_date, event_time, description, location, registration_link) VALUES
('Youth Conference', '2025-06-15', '09:00:00', 'A transformational one-day spiritual growth event designed for our youth members. Join us for workshops, discussions, and worship.', 'Main Fellowship Hall', '../registration.html'),
('Community Clean-Up', '2025-07-05', '08:00:00', 'Help us clean local streets and parks. Let\'s make a difference while building fellowship and showing Christ\'s love in action.', 'Central Park Area', '../php/registration.php');
