export type Track = {
  id?: string
  name: string
  artist_name: string
  img_url: string
  img_thumbnail_url: string
  spotify_uri: string
}

export type MaybeTrack = Track | null | undefined
