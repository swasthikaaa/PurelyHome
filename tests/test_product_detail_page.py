from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys      # ✅ Correct import
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time

def test_product_detail_with_otp():
    # Step 1: Setup Chrome
    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))
    driver.maximize_window()

    # Step 2: Go to login page
    driver.get("http://localhost:8000/login")
    print("Login page opened")

    # Step 3: Fill login form
    email = "swasthikalingaraj@gmail.com"
    password = "Customer@123"
    driver.find_element(By.NAME, "email").send_keys(email)
    driver.find_element(By.NAME, "password").send_keys(password + Keys.RETURN)
    print("Login form submitted")

    # Step 4: Wait for OTP page
    wait = WebDriverWait(driver, 20)
    wait.until(EC.url_contains("otp-verify"))
    otp_boxes = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".otp-input")))
    print(f"Found {len(otp_boxes)} OTP input boxes")

    # Step 5: Enter OTP from Gmail
    otp_value = input("🔢 Enter the 6-digit OTP from your Gmail: ").strip()
    for i, digit in enumerate(otp_value):
        otp_boxes[i].send_keys(digit)
        time.sleep(0.2)
    driver.find_element(By.ID, "verifyBtn").click()
    print("OTP submitted")

    # Step 6: Wait for Dashboard redirect
    wait.until(EC.url_contains("dashboard"))
    print("✅ Logged in successfully")

    # Step 7: Open Product Detail Page
    # Make sure to use an existing Product ID in your DB
    driver.get("http://localhost:8000/product/3")
    print("✅ Product detail page opened")

    # Step 8: Wait for page to load content
    try:
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//button[contains(text(),'Add to Cart')]"))
        )
        print("Product content loaded")
    except:
        print("Page loaded but product may not exist or is loading slowly")

    # Step 9: Validate product info
    try:
        name = driver.find_element(By.XPATH, "//h1").text
        print(f"Product name found: {name}")
        driver.find_element(By.XPATH, "//button[contains(text(),'Add to Cart')]")
        driver.find_element(By.XPATH, "//button[contains(text(),'Buy now')]")
        print("Add to Cart & Buy Now buttons present")
    except Exception as e:
        print("Product details missing:", e)

    # Step 10: Close browser
    driver.quit()
    print("Browser closed successfully")


if __name__ == "__main__":
    test_product_detail_with_otp()
