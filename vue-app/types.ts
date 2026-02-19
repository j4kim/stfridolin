export type Track = {
  id?: string
  name: string
  artist_name: string
  img_url: string
  img_thumbnail_url: string
  spotify_uri: string
  priority:number
  proposed_by?:{id:number,name:string},
}

export type MaybeTrack = Track | null | undefined
