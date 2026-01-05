import axios from "axios";
import { route } from "../vendor/tightenco/ziggy";
import { toast } from "vue-sonner";
import { useClientStore } from "./stores/client";

export function redirectToLogin(intended) {
    location = route("filament.admin.auth.login", { intended });
}

export class Request {
    constructor(routeName) {
        this.routeName = routeName;
        this.routeParams = null;
        this.config = { headers: { "X-Client-Id": useClientStore().clientId } };
        this.toast = true;
    }

    async send(method) {
        this.config.method = method;
        this.config.url = route(this.routeName, this.routeParams);
        try {
            const response = await axios(this.config);
            return response.data;
        } catch (error) {
            const r = error.response;
            const msg = r?.data?.message ?? r?.statusText;
            if (r?.status === 419 && !this.retry) {
                return await this.refreshTokenAndRetry(method);
            }
            return this.handleError(r, msg, error);
        }
    }

    async refreshTokenAndRetry(method) {
        await api("sanctum.csrf-cookie").get();
        this.retry = true;
        return await this.send(method);
    }

    handleError(response, msg, error) {
        if (response?.status === 401) {
            toast.error("Vous êtes déconnecté", {
                description: "Aller à la page de login ?",
                action: {
                    label: "Login",
                    onClick: () => redirectToLogin(location.href),
                },
            });
        } else if (msg && this.toast) {
            toast.error(msg);
        }
        throw error;
    }

    params(params) {
        this.routeParams = params;
        return this;
    }

    data(data) {
        this.config.data = data;
        return this;
    }

    noToast(value = true) {
        this.toast = !value;
        return this;
    }

    async get() {
        return await this.send("get");
    }

    async post() {
        return await this.send("post");
    }

    async put() {
        return await this.send("put");
    }

    async del() {
        return await this.send("delete");
    }
}

export function api(routeName) {
    return new Request(routeName);
}
