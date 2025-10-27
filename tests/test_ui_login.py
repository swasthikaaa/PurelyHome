# C:\xampp\htdocs\PurelyHome\tests\test_login.py

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time


def test_invalid_login():
    # Initialize Chrome browser with Service object
    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.maximize_window()

    # Step 1: Open Laravel login page
    driver.get("http://127.0.0.1:8000/login")
    print("Laravel login page opened successfully")

    # Step 2: Enter invalid email and password
    try:
        driver.find_element(By.NAME, "email").send_keys("invalid@example.com")
        driver.find_element(By.NAME, "password").send_keys("wrongpass" + Keys.RETURN)
        print("Entered invalid credentials and submitted form")
    except Exception as e:
        print("Unable to find login fields:", e)
        driver.quit()
        return

    # Step 3: Wait for Laravel validation response
    time.sleep(3)

    # Step 4: Verify error message (red alert box)
    try:
        error_box = driver.find_element(By.CLASS_NAME, "bg-red-100")
        print("Test Passed – Error message displayed:", error_box.text)
    except:
        print("Test Failed – Error message not found")

    # Step 5: Close the browser
    driver.quit()
    print("Browser closed successfully")


if __name__ == "__main__":
    test_invalid_login()
