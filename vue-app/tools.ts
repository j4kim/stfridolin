import { route } from "../vendor/tightenco/ziggy";

export function redirectToLogin(intended?: string): void {
  location.assign(route("filament.admin.auth.login", { intended }));
}