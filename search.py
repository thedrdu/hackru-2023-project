import os
from dotenv import load_dotenv
import aiohttp
import asyncio
import ssl, certifi
import sys

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
    id = anime["data"][0]["node"]["id"]
    
    response2 = await session.get(url=f"https://api.myanimelist.net/v2/anime/{id}?fields=genres", headers = {
        'X-MAL-CLIENT-ID': CLIENT_ID
        },ssl=sslcontext)

    genres = await response2.json()

    print(anime["data"][0]["node"])
    print(genres["genres"])
    
    await session.close()

if __name__ ==  '__main__':
    loop = asyncio.new_event_loop()
    asyncio.set_event_loop(loop)
    loop.run_until_complete(search(sys.argv[1]))