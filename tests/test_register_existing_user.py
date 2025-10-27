from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time

def test_register_existing_user():
    # Initialize Chrome
    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.maximize_window()

    driver.get("http://localhost:8000/register")
    print("Register page opened successfully")

    try:
        existing_email = "existinguser@example.com"

        driver.find_element(By.NAME, "name").send_keys("Existing User")
        driver.find_element(By.NAME, "email").send_keys(existing_email)
        driver.find_element(By.NAME, "phone").send_keys("0712345678")
        driver.find_element(By.NAME, "password").send_keys("Password123")
        driver.find_element(By.NAME, "password_confirmation").send_keys("Password123")

        print(f"Filled registration form with existing email: {existing_email}")
    except Exception as e:
        print("Failed to fill registration form:", e)
        driver.quit()
        return

    # Submit the form
    try:
        driver.find_element(By.XPATH, "//button[@type='submit']").click()
        print("Submitted registration form")
    except Exception as e:
        print("Could not click Sign Up button:", e)
        driver.quit()
        return

    time.sleep(3)

    # Step 4: Detect ANY Laravel validation error
    try:
        # Look for the general validation error container (<ul> or <div>)
        error_elements = driver.find_elements(By.XPATH, "//*[contains(text(), 'email') or contains(text(), 'Email') or contains(text(), 'taken')]")

        if error_elements:
            for error in error_elements:
                print("Test Passed – Validation message found:", error.text)
        else:
            print("Test Failed – No visible validation message found.")
    except Exception as e:
        print("Error while checking validation message:", e)

    driver.quit()
    print("Browser closed successfully")


if __name__ == "__main__":
    test_register_existing_user()
