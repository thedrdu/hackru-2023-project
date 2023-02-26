import os
from dotenv import load_dotenv
import aiohttp
import ssl, certifi

load_dotenv()
CLIENT_ID = os.getenv("CLIENT_ID")
CLIENT_SECRET = os.getenv("CLIENT_SECRET")

async def search(query: str):
    session = aiohttp.ClientSession()
    sslcontext = ssl.create_default_context(cafile=certifi.where())
    response = await session.get(url=f"https://api.myanimelist.net/v2/anime?q={query}&limit=1", headers = {
        'X-MAL-CLIENT-ID': CLIENT_ID
        },ssl=sslcontext)

    anime = await response.json()
    print(anime)
    if "error" in anime: #Bad request
        return [2]
    if "data" in anime:
        if len(anime["data"]) == 0: #No results found
            return [1]
    id = anime["data"][0]["node"]["id"]

    response2 = await session.get(url=f"https://api.myanimelist.net/v2/anime/{id}?fields=genres,recommendations", headers = {
        'X-MAL-CLIENT-ID': CLIENT_ID
        },ssl=sslcontext)

    data = await response2.json()
    # print(data)
    title = anime["data"][0]["node"]["title"]
    genre_list = []
    recommendation_list = []
    for genre in data["genres"]:
        genre_list.append(genre["name"])
    for recommendation in data["recommendations"]:
        recommendation_list.append(recommendation["node"]["title"])
    # if len(recommendation_list) > 5:
        
    response.close()
    response2.close()
    await session.close()
    return 0, title, genre_list, recommendation_list

async def get_recommendations(query: str):
    session = aiohttp.ClientSession()
    sslcontext = ssl.create_default_context(cafile=certifi.where())
    response = await session.get(url=f"https://api.myanimelist.net/v2/anime?q={query}&limit=1", headers = {
        'X-MAL-CLIENT-ID': CLIENT_ID
        },ssl=sslcontext)

    anime = await response.json()
    print(anime)
    if "error" in anime: #Bad request
        return [2]
    if "data" in anime:
        if len(anime["data"]) == 0: #No results found
            return [1]
    id = anime["data"][0]["node"]["id"]

    response2 = await session.get(url=f"https://api.myanimelist.net/v2/anime/{id}?fields=genres,recommendations", headers = {
        'X-MAL-CLIENT-ID': CLIENT_ID
        },ssl=sslcontext)

    data = await response2.json()
    # print(data)
    title = anime["data"][0]["node"]["title"]
    genre_list = []
    recommendation_list = []
    for genre in data["genres"]:
        genre_list.append(genre["name"])
    for recommendation in data["recommendations"]:
        recommendation_list.append(recommendation["node"]["title"])
    print(recommendation_list)
    # if len(recommendation_list) > 5:
        
    response.close()
    response2.close()
    await session.close()
    return recommendation_list