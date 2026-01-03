import axios from "axios";
import { route } from "../vendor/tightenco/ziggy";
import { toast } from "vue-sonner";
import { useClientStore } from "./stores/client";

async function refreshTokenAndRetry(config) {
    await get("sanctum.csrf-cookie");
    return await axiosRequest(config, true);
}

export function redirectToLogin(intended) {
    location = route("filament.admin.auth.login", { intended });
}

export async function axiosRequest(config, isRetry = false) {
    try {
        const response = await axios(config);
        return response.data;
    } catch (error) {
        let msg = error.response?.data?.message ?? error.response?.statusText;
        if (error.response?.status === 419 && !isRetry) {
            return await refreshTokenAndRetry(config);
        }
        if (error.response?.status === 401) {
            toast.error("Vous êtes déconnecté", {
                description: "Aller à la page de login ?",
                action: {
                    label: "Login",
                    onClick: () => redirectToLogin(location.href),
                },
            });
        } else if (msg) {
            toast.error(msg);
        }
        throw error;
    }
}

export async function request(method, name, params = null, data = null) {
    const url = route(name, params);
    const headers = { "X-Client-Id": useClientStore().clientId };
    return await axiosRequest({ method, url, data, headers });
}

export async function get(name, params = null) {
    return await request("get", name, params);
}

export async function post(name, params = null, data = null) {
    return await request("post", name, params, data);
}

export async function put(name, params = null, data = null) {
    return await request("put", name, params, data);
}

export async function del(name, params = null) {
    return await request("delete", name, params);
}
