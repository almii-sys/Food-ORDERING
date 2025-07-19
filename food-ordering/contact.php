<?php include 'includes/header.php'; ?>

<div class="contact-page">
    <h1 class="page-title">Contact Us</h1>
    
    <div class="contact-container">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p>Have any questions or feedback? Reach out to us using the contact information below or fill out the form.</p>
            
            <div class="contact-method">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h3>Address</h3>
                    <p>123 Food Street, City, Country</p>
                </div>
            </div>
            
            <div class="contact-method">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Phone</h3>
                    <p>(123) 456-7890</p>
                </div>
            </div>
            
            <div class="contact-method">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email</h3>
                    <p>info@burgerhaven.com</p>
                </div>
            </div>
            
            <div class="contact-method">
                <i class="fas fa-clock"></i>
                <div>
                    <h3>Opening Hours</h3>
                    <p>Monday - Friday: 11am - 10pm</p>
                    <p>Saturday - Sunday: 11am - 11pm</p>
                </div>
            </div>
        </div>
        
        <div class="contact-form">
            <h2>Send a Message</h2>
            <form action="process_contact.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="form-btn">Send Message</button>
            </form>
        </div>
    </div>
    
    <div class="map-container">
        <h2>Find Us</h2>
        <div class="map">
            <!-- Placeholder for a map -->
            <div style="height: 400px; background-color: #f9f9f9; display: flex; justify-content: center; align-items: center; border-radius: 8px;">
                <p style="color: #999;">Map will be displayed here</p>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .contact-info, .contact-form {
        flex: 1;
        min-width: 300px;
    }
    
    .contact-info h2, .contact-form h2, .map-container h2 {
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .contact-info h2::after, .contact-form h2::after, .map-container h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #e74c3c;
    }
    
    .contact-info > p {
        margin-bottom: 30px;
        color: #666;
    }
    
    .contact-method {
        display: flex;
        margin-bottom: 20px;
    }
    
    .contact-method i {
        font-size: 1.5rem;
        color: #e74c3c;
        margin-right: 15px;
        margin-top: 5px;
    }
    
    .contact-method h3 {
        margin-bottom: 5px;
    }
    
    .contact-method p {
        color: #666;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    
    .form-btn {
        padding: 12px 30px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .form-btn:hover {
        background-color: #c0392b;
    }
    
    .map-container {
        margin-bottom: 30px;
    }
</style>

<?php include 'includes/footer.php'; ?>