const LOCAL_URL = "http://127.0.0.1:8000";
const PROD_URL = "http://192.168.1.220:8000";
const BASE_URL = LOCAL_URL;

export function asset(url) {
	return BASE_URL + "/" + url;
}
