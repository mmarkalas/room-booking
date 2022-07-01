
import HttpService, { type ApiResponse, type CommonObjectKeys } from '../http-service';
import authHeader from './auth-header';

export interface LoginPayload extends CommonObjectKeys {
  username: string;
  password: string;
}

export interface RegistrationPayload extends CommonObjectKeys {
  name: string;
  username: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface User extends CommonObjectKeys {
  created_at: string;
  email: string;
  id: number;
  name: string;
  updated_at: string;
  username: string;
}

export default class AuthService extends HttpService {
  async login(formData: LoginPayload): Promise<ApiResponse> {
    const response = await this.post('/login', formData);

    if(response.success) {
      localStorage.setItem('token', JSON.stringify(response.data));
    }

    return response;
  }

  async logout(): Promise<ApiResponse> {
    const response = await this.post('/logout', null);

    if(response.success) {
      localStorage.removeItem('token');
    }

    return response;
  }

  async register(formData: RegistrationPayload): Promise<ApiResponse> {
    const response = await this.post('/register', formData);

    if(response.success) {
      const data : Object = response.data;

      const { access_token, expires_at } = data as {
        access_token: string,
        expires_at: number,
      };

      localStorage.setItem('token', JSON.stringify({
        access_token,
        expires_at
      }));
    }

    return response;
  }
}
