import Pusher from "pusher-js";

export const pusher = new Pusher(document.body.dataset.pusherKey, {
    cluster: "eu",
});
