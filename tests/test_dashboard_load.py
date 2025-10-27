from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time

def test_dashboard_with_otp():
    service = Service(ChromeDriverManager().install())
    driver = webdriver.Chrome(service=service)
    driver.maximize_window()

    # Step 1: Open login page
    driver.get("http://localhost:8000/login")
    print("Login page opened successfully")

    # Step 2: Fill login form
    email = "swasthikalingaraj@gmail.com"
    password = "Customer@123"

    driver.find_element(By.NAME, "email").send_keys(email)
    driver.find_element(By.NAME, "password").send_keys(password + Keys.RETURN)
    print(f"Submitted login form for {email}")

    # Step 3: Wait for OTP page
    time.sleep(3)
    if "otp-verify" in driver.current_url:
        print("Redirected to OTP verification page")
    else:
        print(f"Expected OTP page but got: {driver.current_url}")
        driver.quit()
        return

    # Step 4: Handle OTP
    wait = WebDriverWait(driver, 15)
    otp_boxes = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, ".otp-input")))
    print(f"Found {len(otp_boxes)} OTP input boxes")

    otp_value = input("🔢 Enter the 6-digit OTP from your Gmail: ").strip()
    for i, digit in enumerate(otp_value):
        otp_boxes[i].send_keys(digit)
        time.sleep(0.2)

    verify_btn = driver.find_element(By.ID, "verifyBtn")
    driver.execute_script("arguments[0].scrollIntoView(true);", verify_btn)
    driver.execute_script("arguments[0].click();", verify_btn)
    print("Clicked Verify button")

    # Step 5: Wait for dashboard to load
    time.sleep(5)
    if "dashboard" in driver.current_url:
        print("Successfully logged in and redirected to Dashboard")
    else:
        print(f"OTP failed or redirect incorrect (URL: {driver.current_url})")
        driver.quit()
        return

    # Step 6: Check Hero section text
    try:
        hero = driver.find_element(By.XPATH, "//*[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'welcome to purely home')]")
        print("Hero section found:", hero.text)
    except:
        print("Hero section text not found — may be hidden or animated")

    # Step 7: Scroll to bottom and check 'Our Latest Creations'
    try:
        driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        time.sleep(2)
        latest = driver.find_element(By.XPATH, "//*[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'our latest creations')]")
        print("'Our Latest Creations' section found:", latest.text)
    except:
        print("'Our Latest Creations' section not found (try increasing delay or scroll depth)")

    driver.quit()
    print("Browser closed successfully")


if __name__ == "__main__":
    test_dashboard_with_otp()
