# C:\xampp\htdocs\PurelyHome\tests\test_forgot_password.py

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time


def test_forgot_password_link():
    # Initialize browser
    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.maximize_window()

    # Step 1: Open the login page
    driver.get("http://127.0.0.1:8000/login")
    print("Laravel login page opened successfully")

    # Step 2: Locate and click 'Forgot your password?' link
    try:
        forgot_link = driver.find_element(By.LINK_TEXT, "Forgot your password?")
        forgot_link.click()
        print("Clicked on 'Forgot your password?' link")
    except Exception as e:
        print("Failed to locate or click link:", e)
        driver.quit()
        return

    # Step 3: Wait for navigation
    time.sleep(3)

    # Step 4: Verify that it navigates to the correct page
    current_url = driver.current_url
    if "forgot-password" in current_url:
        print("Test Passed – Navigated to password reset page:", current_url)
    else:
        print("Test Failed – Did not navigate correctly (Current URL:", current_url, ")")

    # Step 5: Close browser
    driver.quit()
    print("Browser closed successfully")


if __name__ == "__main__":
    test_forgot_password_link()
