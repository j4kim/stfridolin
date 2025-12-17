# Jukeboxe

- [Wireframe](https://www.tldraw.com/p/pp12CO_xCTQlyz75N76Ra?d=v44.-192.2076.1369.9w22Wbx_xOmkwdZr8EY-F)
- [Data model](https://www.tldraw.com/p/pp12CO_xCTQlyz75N76Ra?d=v66.-260.1932.1274.page)

## Dependencies

- php 8.4
- node
- A Spotify Premium account
- A Pusher Channels account

## Setup

```
composer run setup
```

### Reset database

```
php artisan migrate:fresh --seed
```

## Run

```
composer run dev
```

## Spotify

- Create a Spotify App (See Getting started in [docs](https://developer.spotify.com/documentation/web-api))
- Type `http://127.0.0.1:8000/spotify-callback` as Redirect URI
- Check "Web API" for "APIs used"
- Fill `SPOTIFY_CLIENT_ID` and `SPOTIFY_CLIENT_SECRET` in `.env`
- Open http://localhost:8000/spotify. Log to the app using `test@example.com`/`password`
- You should see: No Spotify Token. Click the link to log in to Spotify
- Open Spotify and play a track.
- Reload http://localhost:8000/spotify
- In the list of devices, select one
- Search a track and play
- You should see the played track in the header in http://localhost:8000/boxing

## Pusher

Pusher is used as Websockets server.

- Create an app from your [Pusher dashboard](https://dashboard.pusher.com/)
- Copy the credentials in `PUSHER_*` variables in `.env`
