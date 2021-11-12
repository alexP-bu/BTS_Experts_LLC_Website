<?php
include_once "header.php";
?>
<div class="contact_us_content">
    <form action="contact_form.inc.php" method="post" class="contact_us_content_contact_form">
        <h2 id="contact_form_title"><span class="blue_text">C</span>ONTACT <span class="blue_text">US</span></h2>
        <h5 id="contact_form_title_subscript">Fields with "<span class="red_text">*</span>" are required.</h5>        
        <p id="contact_form_name_tag">Your Name:<span class="red_text">*</span></p>
        <p id="contact_form_company_name_tag">Company Name:</p>
        <p id="contact_form_email_tag">Email:<span class="red_text">*</span></p>
        <p id="contact_form_phone_tag">Phone:</p>
        <p id="contact_form_message_subject_tag">Message Subject:<span class="red_text">*</span></p>
        <p id="contact_form_message_tag">Message:<span class="red_text">*</span></p>
        <input type="text" id="first_name" name="first_name" placeholder="First">
        <input type="text" id="last_name" name="last_name" placeholder="Last">
        <input type="tel" id="phone_number" name="phone" placeholder="111-111-1111">
        <input type="text" id="company_name" name="company_name" placeholder="e.g. Duracell">
        <input type="email" id="email" name="email" placeholder="e.g. hello@gmail.com">
        <input type="text" id="message_subject" name="message_subject" placeholder="Maximum: 300 Characters">
        <textarea id="message" name="message"></textarea>   
        <input id="contact_form_submit_button" type="submit" value="Submit">
        <p class="error_paragraph">
            <?php
                if (isset($_GET["error"])){
                    if($_GET["error"] == "Empty_Required_Fields"){
                        echo "<p class=\"red_text\">Please fill in all required fields!</p>";
                    }else if(str_contains($_GET["error"],"invalid_length")){
                        $error_str = str_replace("_"," ",$_GET["error"]);
                        echo "<p class=\"red_text\">{$error_str}: please enter shorter values</p>";
                    }else if(str_contains($_GET["error"],"invalid_format_of_phone")){
                        $error_str = str_replace("_"," ",$_GET["error"]);
                        echo "<p class=\"red_text\">{$error_str}: please enter valid phone number</p>";
                    }
                }
            ?>
        </p>
    </form>
</div>         
<?php
include_once "footer.php";
?>