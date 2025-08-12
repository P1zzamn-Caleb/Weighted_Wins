from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
import os.path
import time



EARLIEST_YEAR=2003
CURR_YEAR=2026
NUM_TEAMS=365

defaultYearOption=11


url = "https://www.espn.com/mens-college-basketball/teams"
chromePath = "C:\\Users\\Caleb Ellis\\Downloads\\chromedriver-win64.zip"

chrome_install = ChromeDriverManager().install()
folder = os.path.dirname(chrome_install)
chromedriver_path = os.path.join(folder, "chromedriver.exe")
service = webdriver.ChromeService(chromedriver_path)

chrome_options = Options()
chrome_options.add_experimental_option("detach", True)
chrome_options.add_argument(chromePath)
chrome_options.add_argument(r'--profile-directory=Profile 1')




#paths to different parts of the website
DROPDOWN_MENU_BUTTON_PATH="/html/body/div[1]/div/div/div/div/main/div[2]/div/div[5]/div/div/section/div/section/div[2]/div/select[1]"


#timer length
TIME_DURATION = 1

NUM_YEARS=CURR_YEAR-EARLIEST_YEAR

#paths to the data
dataPath = '//span[contains(@data-testid, "symbol")]'
opponentNamePath = '//a[contains(@class, "AnchorLink") and contains(@href,"/mens-college-basketball/team/_/id") and not(contains(@class, "Nav__Secondary__Menu__Link")) and not(descendant::img)] '
canceledPath = '//td[contains(@class, "tc ttu Table__TD")]'
fullRowPath = '//tr[contains(@class, "Table__TR Table__TR--sm Table__even") and descendant ::*[contains(@data-testid, "date")] ] '
scoreClassName ="Table__TD"
noDataPath = '//div[contains(@class, "Schedule__no-data")]'
drivers = {}

def open_driver():
   driver = webdriver.Chrome(service = service, options = chrome_options)
   
   driver.maximize_window() # For maximizing window
   driver.implicitly_wait(20) # gives an implicit wait for 20 seconds

   driver.get(url)

   driver.implicitly_wait(20)
   window_handles = driver.window_handles
   driver.switch_to.window(window_handles[-1])

   return driver

def get_team_name(driver, currIndex, wait):
   teamName=driver.find_elements(By.XPATH, '//h2[contains(@class, "di clr-gray-01 h5")]')
   
   return teamName[currIndex].text

def open_team_stats(driver, url, wait):
   
   for attempts in range (5):
      try:
         driver.get(url)
         break
      except:
         print("fail")
         continue

#creates an array of booleans
def createHasBeenOpenedArray():
    hasBeenOpened=[]
    for i in range (NUM_YEARS):
        hasBeenOpened.append(False)

    return hasBeenOpened



   

def print_Data(year, driver, wait):
    print(f"{year}.txt")

    time.sleep(0.5)

    driver.implicitly_wait(0)
    try:
        WebDriverWait(driver, 0.5).until(EC.presence_of_element_located((By.CLASS_NAME, "Schedule__no-data")))
        print("No data found.")
        return
    except TimeoutException:
        print("there is data")
        pass
    driver.implicitly_wait(20)

    data=driver.find_elements(by='xpath', value=dataPath.strip())

   

    opponentIndex=0
    dataIndex=0

    for attempts in range(5):
        try:
            fullRow = [elem.text for elem in driver.find_elements(By.XPATH, fullRowPath)]
            dataTexts = [elem.text for elem in driver.find_elements(By.XPATH, dataPath)]
            opponentTexts = [elem.text for elem in driver.find_elements(By.XPATH, opponentNamePath)]
            break
        except:
            print("went stale")
            continue

    for rows in fullRow:
        if "CANCELLED" in rows or "POSTPONED" in rows or "CANCELED" in rows:
            opponentIndex+=1
            continue
        try:
            print(opponentTexts[opponentIndex] + " " + dataTexts[dataIndex])
            opponentIndex+=1
            dataIndex+=1
        #skips over the data if it fails
        except:
            print("failed to write")
            continue

    return True

#uses the dropdown menu to change the year
def change_Year(choiceIndex, driver, wait):
   selectionPath=f"/html/body/div[1]/div/div/div/div/main/div[2]/div/div[5]/div/div/section/div/section/div[2]/div/select[1]/option[{choiceIndex}]"
   isClicked=False
   
   time.sleep(0.2)
   start_time=time.time()
   while True:
      if time.time() - start_time > TIME_DURATION:
         print(f"Function timed out after {TIME_DURATION} seconds.")
         break
      try:
         wait.until(EC.element_to_be_clickable((By.XPATH, DROPDOWN_MENU_BUTTON_PATH))).click()
         wait.until(EC.element_to_be_clickable((By.XPATH, selectionPath))).click()
         isClicked=True
         break
      except:
         continue

   return isClicked

def run_data_getter(hasBeenOpened):
    driver = open_driver()
    wait=WebDriverWait(driver, 10)
    team_links = driver.find_elements(By.XPATH, '//a[contains(@class, "AnchorLink") and contains(@href, "/schedule/")]')
    urls = [link.get_attribute("href") for link in team_links]

    driver.get(urls[29])

    for year in range (CURR_YEAR, EARLIEST_YEAR, -1):
            
        #creates index for yearNum and sets the mode to append when call_Get_Data is called
        yearNum=CURR_YEAR-year
        

        choiceIndex=yearNum+2

        print("changing year")
        isClicked = change_Year(choiceIndex, driver, wait)
        
        if isClicked == True:
            print("getting Data")
            print_Data(year-1, driver, wait)
            print("data printed")
            

                    


            
#runs the program
def main():
    hasBeenOpened=createHasBeenOpenedArray()

    run_data_getter(hasBeenOpened)

    
   
if __name__ == "__main__":
   main()

