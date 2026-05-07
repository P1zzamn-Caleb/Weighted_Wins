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
import re



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
postSeasonPathName="tl ttu Table__TD"
postSeasonPath='//td[contains(@class, "tl ttu Table__TD")]'
allTeamPath='//span[contains(@class, "tc pr2")]'
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


#calls get_Data function with the proper file name and mode
def call_Get_Data(year, team, hasBeenOpened, driver, wait):
   #makes the new file name
   fileName=f"scoreData{year}.txt"

   #opens a new file or overwrites a file and then closes it when done
   if hasBeenOpened == False:
      mode = "w"
   else: 
      mode="a"
   
   get_Data(year, fileName, mode, team, driver, wait)
   
#was working on this function
def get_Data(year, fileName, mode, team, driver, wait):
   #waits until the website is loaded
   #driver.implicitly_wait(1)
   data=driver.find_elements(by='xpath', value=dataPath.strip())
   teamNames = []
   dataTexts = []

   

   with open(fileName, mode) as gameDataFile:
      gameDataFile.write("Team: " + team + "\n")
      print(fileName)
      opponentIndex=0
      dataIndex=0
      isTherePostSeason=True

      time.sleep(0.5)

      driver.implicitly_wait(0)
      try:
         WebDriverWait(driver, 0.5).until(EC.presence_of_element_located((By.CLASS_NAME, "Schedule__no-data")))
         print("No data found.")
         return
      except TimeoutException:
        print("there is data")
        pass

      try:
         WebDriverWait(driver, 1).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".tl.ttu.Table__TD")))
         postSeason = [elem.text for elem in driver.find_elements(By.XPATH, postSeasonPath)]
      except TimeoutException:
        print("there is no postseason")
        isTherePostSeason=False
        pass
      driver.implicitly_wait(20)


      for attempts in range(5):
         try:
            fullRow = [elem.text for elem in driver.find_elements(By.XPATH, fullRowPath)]
            break
         except:
            try:
               WebDriverWait(driver, 0.2).until(EC.presence_of_element_located((By.CLASS_NAME, "Schedule__no-data")))
               print("No data found.")
               return 0
            except:
               print("Schedule data exists.")
            print("went stale")
            continue

      i=0
      for row in fullRow:
         teamName = row.split("\n")


         teamNames.append(teamName[2]) #append new Team Name
         teamNames[i] = re.sub(r'\d+', '', teamNames[i])          # remove numbers
         teamNames[i] = re.sub(r'\*', '', teamNames[i])
         teamNames[i] = re.sub(r'\s+', ' ', teamNames[i])      # collapse multiple spaces
         teamNames[i] = teamNames[i].strip()
         i+=1

         dataText = teamName[3]
         dataTexts.append(dataText[0])

      postSeasonGameCount = 0
      for rows in fullRow:
         if "CANCELLED" in rows or "POSTPONED" in rows or "CANCELED" in rows:
            opponentIndex+=1
            continue
         try:
            if(isTherePostSeason):
               if(postSeasonGameCount > len(postSeason)-1):
                  print(teamNames[opponentIndex] + " " + dataTexts[dataIndex])
                  #writes the data to the file
                  gameDataFile.write(teamNames[opponentIndex] + "\n" + dataTexts[dataIndex] + "\n")

               else:
                  postSeasonGameCount+=1
            else:
               print(teamNames[opponentIndex] + " " + dataTexts[dataIndex])
               #writes the data to the file
               gameDataFile.write(teamNames[opponentIndex] + "\n" + dataTexts[dataIndex] + "\n")

            opponentIndex+=1
            dataIndex+=1

         #skips over the data if it fails
         except:
            print("failed to write")
            continue

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
   row=1
   column=1

   

   for currIndex in range(NUM_TEAMS):
        #creates the index text of the driver that will be used for the drivers dict
        currIndexText=f"driver{currIndex}"
        
            
        #creates a new driver using the driversdict
        drivers[currIndexText] = open_driver()
        wait = WebDriverWait(drivers[currIndexText], 10)

        team_links = drivers[currIndexText].find_elements(By.XPATH, '//a[contains(@class, "AnchorLink") and contains(@href, "/schedule/")]')
        urls = [link.get_attribute("href") for link in team_links]
        

        teamName = get_team_name(drivers[currIndexText], currIndex, wait)
        drivers[currIndexText].get(urls[currIndex])
               

        if teamName == -1:
           continue

        #teamNameText=teamName.text
        print ("TeamName: " + teamName)

        for year in range (CURR_YEAR, EARLIEST_YEAR, -1):
            
            #creates index for yearNum and sets the mode to append when call_Get_Data is called
            yearNum=CURR_YEAR-year
            

            choiceIndex=yearNum+2


            isClicked = change_Year(choiceIndex, drivers[currIndexText], wait)
            if isClicked == True:
               call_Get_Data(year-1, teamName, hasBeenOpened[yearNum], drivers[currIndexText], wait)
               hasBeenOpened[yearNum]=True
            
            
        drivers[currIndexText].quit()
        time.sleep(1)


        currIndex+=1
        if column >= 2:    
            row+=1
            column = 1
        else:
            column+=1
            
#runs the program
def main():
    hasBeenOpened=createHasBeenOpenedArray()

    run_data_getter(hasBeenOpened)

    
   
if __name__ == "__main__":
   main()

