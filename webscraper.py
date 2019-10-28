#!/usr/bin/env python
import requests
import urllib.request
import time
import bs4
import json



url1 = "https://politico.com"


politicoRes = requests.get(url1)
soup = bs4.BeautifulSoup(politicoRes.text, "html.parser")


links = {}
links['politico'] = []

for ana in soup.findAll('a'): 
    if ana.parent.name == 'h1':
        if(len(links['politico']) < 20):
            download_url = ana['href']
            print(ana['href'])
            links['politico'].append({
            'link': download_url,
            'head': ana.text
            })
            time.sleep(0.01)
        else:
            print("finished")
        

with open('data.txt', 'w') as outfile:
    json.dump(links, outfile)
