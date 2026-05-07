from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait       
from selenium.webdriver.support import expected_conditions as EC
import os.path
import time



TEAM_NAME_PATH="//h2[contains(@class, 'clr-gray-01 h5')]"


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

def get_Team_Names():
   driver = open_driver()
   data=driver.find_elements(by='xpath', value=TEAM_NAME_PATH)
   fileName="teamNames.txt"
   #teamNameClassName="AnchorLink"
   
   with open(fileName, "w") as gameDataFile:

      for datas in data:
         try:
            #finds the data
            #newTeamData=datas.find_element(By.CLASS_NAME, teamNameClassName).text
            newTeamData=datas.text
            #prints the data out so that I can see it
            print(newTeamData)
            #writes the data to the file
            gameDataFile.write(newTeamData + "\n")
            #skips over the data if it fails
         except:
            print("fail")
            continue

def main():
   get_Team_Names()

main()