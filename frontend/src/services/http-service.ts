import authHeader from "./auth/auth-header";

export interface ApiResponse {
  data: Array<any> | Object;
  message: string;
  success: boolean;
}

export interface CommonObjectKeys {
  [key: string]: string | number | Object | undefined;
}

export default class HttpService {
  baseUrl: string = '';

  defaultheaders = [['Content-Type', 'application/json']];
  requestHeaders: HeadersInit;

  constructor() {
    this.baseUrl = 'http://localhost/api';

    this.requestHeaders = new Headers([
      ...this.defaultheaders,
      ...authHeader()
    ]);
  }

  async post(path: string, payload: any, headers: any = {}): Promise<ApiResponse> {
    const response = await fetch(`${this.baseUrl}${path}`, {
      method: 'POST',
      body: JSON.stringify(payload),
      headers : this.requestHeaders,
    })
    .then((resp) => resp.json())
    .catch((e) => console.log(e));

    return response;
  }

  async put(path: string, payload: any): Promise<ApiResponse> {
    const response = await fetch(`${this.baseUrl}${path}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
      headers: this.requestHeaders,
      mode: "cors"
    }).then((resp) => resp.json());

    return response;
  }

  async get(path: string, payload?: any, headers?: any): Promise<ApiResponse> {
    let url = `${this.baseUrl}${path}`;

    if (typeof payload !== 'undefined' && payload !== null) {
      const queryParams = Object.keys(payload)
        .map((key) => `${key}=${payload[key]}`)
        .join('&');

      url += `?${queryParams}`;
    }
    console.log(url);
    const response = await fetch(
      url, 
      {
        mode: "cors",
        headers: this.requestHeaders
      }
    ).then((resp) => resp.json());

    return response;
  }

  async delete(path: string): Promise<ApiResponse> {
    let url = `${this.baseUrl}${path}`;

    const response = await fetch(
      url,
      {
        method: 'DELETE',
        mode: "cors",
        headers: this.requestHeaders
      }
    ).then((resp) => resp.json());

    return response;
  }
}
