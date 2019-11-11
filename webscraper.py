#!/usr/bin/env python
import requests
import urllib.request
import time
import datetime
import bs4
import json



url1 = "https://politico.com"


politicoRes = requests.get(url1)
soup = bs4.BeautifulSoup(politicoRes.text, "html.parser")


links = {}
links['politico'] = []

# should be looking for tag section with class media-item
for ana in soup.findAll('a'): 
    if ana.parent.name == 'h1':
        if(len(links['politico']) < 20):
            download_url = ana['href']
            print(ana['href'])
            links['politico'].append({
            # an img inside a picture tag. The picture tag also has other resolutions.
            'image': None,
            'link': download_url,
            # politico uses a time tag to represent dates. We should put the date of the article here.
            'date': datetime.datetime.now().strftime("%d-%m-%y %I:%M %p"),
            # if we want to, we could put the author here, Its an a tag with rel attribute of author inside a span inside a p with class authors.
            'user': None,
            # the a tags are wrapped in an h1 with class headline
            'head': ana.text,
            # the description is wrapped in a p with class dek
            'body': ""
            })
            time.sleep(0.01)
        else:
            print("finished")
        

with open('data.json', 'w') as outfile:
    json.dump(links, outfile)
