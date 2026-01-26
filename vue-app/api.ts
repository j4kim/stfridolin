import axios from "axios";
import type { AxiosRequestConfig } from "axios";
import { route } from "../vendor/tightenco/ziggy";
import { toast } from "vue-sonner";
import { useClientStore } from "./stores/client";

export function redirectToLogin(intended?: string): void {
  location.assign(route("filament.admin.auth.login", { intended }));
}

export function getErrorMsg(error: any): string | undefined {
    const r = error?.response;
    return r?.data?.message ?? r?.statusText ?? error?.message;
}

export class Request {
  routeName: string;
  routeParams?: any;
  config: AxiosRequestConfig;
  toast = true;
  retry = false;

  constructor(routeName: string) {
    this.routeName = routeName;
    const clientId = useClientStore()?.clientId;
    this.config = { headers: { "X-Client-Id": clientId } } as AxiosRequestConfig;
  }

  async send(method: AxiosRequestConfig["method"]): Promise<any> {
    this.config.method = method;
    this.config.url = route(this.routeName, this.routeParams ?? undefined);
    try {
      const response = await axios(this.config as AxiosRequestConfig);
      return response.data;
    } catch (error: any) {
      const r = error?.response;
      const msg = getErrorMsg(error)
      if (r?.status === 419 && !this.retry) {
        return await this.refreshTokenAndRetry(method);
      }
      return this.handleError(r, msg, error);
    }
  }

  async refreshTokenAndRetry(method: AxiosRequestConfig["method"]): Promise<any> {
    // call the API to refresh CSRF cookie then retry
    await api("sanctum.csrf-cookie").get();
    this.retry = true;
    return await this.send(method);
  }

  handleError(response: any, msg: string | undefined, error: unknown): never {
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
    throw error as any;
  }

  params(params: any): this {
    this.routeParams = params;
    return this;
  }

  data(data: any): this {
    this.config.data = data;
    return this;
  }

  noToast(value = true): this {
    this.toast = !value;
    return this;
  }

  async get(): Promise<any> {
    return await this.send("get");
  }

  async post(): Promise<any> {
    return await this.send("post");
  }

  async put(): Promise<any> {
    return await this.send("put");
  }

  async del(): Promise<any> {
    return await this.send("delete");
  }
}

export function api(routeName: string): Request {
  return new Request(routeName);
}
