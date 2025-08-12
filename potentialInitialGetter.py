from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait       
from selenium.webdriver.support import expected_conditions as EC
import os.path
import time

from scraper import url, dataPath, scoreClassName
from scraper import chromePath, chrome_install, folder, chromedriver_path, service, chrome_options
from scraper import open_driver, open_Calendar, change_Day, change_Month, change_Year

TEAM_NAME_PATH=f"//a[contains(@data-track-nav_item, 'ncb:schedule:team')]"
TIME_DURATION=1

def readInTeamNameFile():
   teamNameDict = {teamName.strip(): i for i, teamName in enumerate(open("newTeamNames.txt"))}
   with open("newTeamNames.txt") as f:
      teamNameList = [team.strip() for team in f]

   print(teamNameDict)
   return teamNameDict, teamNameList

def compare_strings(teamDataText, teamNameDict):
   matchIndex=0
   #compares amount of matching characters to figure out which team it is
   matchIndex = teamNameDict.get(teamDataText.strip(), -1)

   

   return matchIndex

def get_to_correct_date(driver, wait, monthNum):
   for i in range(8+monthNum):
      change_Month(driver, wait)

        

def get_Data(driver, mode, teamNameList, teamNameDict, usedIndexes):
   data=driver.find_elements(by='xpath', value=dataPath)

   teamNameData=driver.find_elements(by='xpath', value=TEAM_NAME_PATH)

   matchIndex=0
   teamDataIndex=0
   scoreData=[]

   with open("newData.txt", mode) as dataFile:
         #compares team names until the names no longer match
         #then uses that name as the official name
         
      for datas in data:

      #gets the teams name and score and writes it to the file
      #if it fails it skips over it.
         start_time=time.time()
         while True:
            if time.time() - start_time > TIME_DURATION:
               print(f"Function timed out after {TIME_DURATION} seconds.")
               break
            try:
               #finds the data
               scoreData=datas.find_element(By.CLASS_NAME,scoreClassName).text
               #prints the data out so that I can see it
               #print(scoreData)
               break
            #skips over the data if it fails
            except:
               continue
         i=0

         for teamData in teamNameData:
            try:
               teamDataText=teamData.text
            except:
               continue
            matchIndex=compare_strings(teamDataText, teamNameDict)
            print(matchIndex)
            if (matchIndex == -1 or matchIndex in usedIndexes):
               continue
            else:
               usedIndexes.add(matchIndex)
               dataFile.write(teamNameList[matchIndex] + "\n" + scoreData + "\n")
               print("Test \n" + teamNameList[matchIndex] + "\n" + scoreData + "\n")
               i+=1
               if i >= 2:
                  break



                  
   return usedIndexes

def readInNewData():
   newDataDict = {teamName.strip(): i for i, teamName in enumerate(open("newData.txt"))}
   with open("newData.txt") as f:
      newDataList = [team.strip() for team in f]

   return newDataDict, newDataList
            

def main():
    teamNameDict, teamNameList=readInTeamNameFile()
    newDataDict, newDataList=readInNewData()
    usedIndexes = set()
    drivers = {}
    mode="w"

    for team in teamNameList:
       if team in newDataDict:
          #print(team + " true")
          continue
       else:
          print(team + " false")



    


main()