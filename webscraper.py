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
for ana in soup.findAll('section', class_ = 'media-item'): 
    if(len(links['politico']) < 20):
        print("\n\n\n")
        #ana['href']
        #print(ana['href'])
        title_ = ana.findAll(class_ = 'headline')
        title = None
        url = None
        for title in title_:
            if title:
                title = title.find('a')
                if title:
                    url = title["href"]
                    title = title.text.strip(" \n")
                    break
        print(f"title: {title}")
        print(f"url: {url}")

        #print(ana.find("p", class_ = "dek"))

        authors_ = ana.find("p", class_ = "authors")
        authors = []
        if authors_:
            authors_ = authors_.findAll(class_ = "vcard")
            for author in authors_:
                authors.append(author.text.strip(" \n"))
        authors = ", ".join(authors)
        print(f"authors: {authors}")


        ana.find('a')['href']

        image = ana.find("img")
        if image:
            image = image['src']
        print(f"image: {image}")

        description = ana.find(class_ = "dek") or ana.find(class_ = "tease")
        if description:
            description = description.text
        print(f"decription: {description}")

        if not "http" in url:
            continue
        resolvedArticle = requests.get(url)
        articleSoup = bs4.BeautifulSoup(resolvedArticle.text, "html.parser")
        time = articleSoup.find('time')
        if time:
            time = time['datetime']
        print(f"time: {time}")

        if not authors:
            authors = []
            authors_ = articleSoup.findAll(class_ = "vcard")
            for author in authors_:
                authors.append(author.text.strip(" \n"))
            authors = ", ".join(authors)
            print(f"authors: {authors}")
        
        if not image:
            image = articleSoup.find("img")
            if image:
                image = image['src']
            print(f"image: {image}")
        
        if not description:
            description = articleSoup.find(class_ = "dek")
            if description:
                description = description.text
            print(f"decription: {description}")

        links['politico'].append({
        # an img inside a picture tag. The picture tag also has other resolutions.
        'image': image,
        'link': url,
        # politico uses a time tag to represent dates. We should put the date of the article here.
        'date': time,
        # if we want to, we could put the author here, Its an a tag with rel attribute of author inside a span inside a p with class authors.
        'user': authors,
        # the a tags are wrapped in an h1 with class headline
        'head': title,
        # the description is wrapped in a p with class dek
        'body': description
        })
        #time.sleep(0.01)
    #else:
        #print("skipping...")
print("finished")        

with open('data.json', 'w') as outfile:
    json.dump(links, outfile)
